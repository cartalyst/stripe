<?php namespace Cartalyst\Stripe\Billing;
/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Carbon\Carbon;
use Cartalyst\Stripe\Billing\Models\IlluminateInvoice;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InvoiceGateway extends StripeGateway {

	/**
	 * The invoice object.
	 *
	 * @var \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	protected $invoice;

	/**
	 * The Invoice Items gateway instance.
	 *
	 * @var \Cartalyst\Stripe\Billing\InvoiceItemsGateway
	 */
	protected $invoiceItems;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Billing\BillableInterface  $billable
	 * @param  mixed  $invoice
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $invoice = null)
	{
		parent::__construct($billable);

		if (is_numeric($invoice))
		{
			$invoice = $this->billable->invoices->find($invoice);
		}

		if ($invoice instanceof IlluminateInvoice)
		{
			$this->invoice = $invoice;
		}
	}

	/**
	 * Returns the Invoice Items gateway instance.
	 *
	 * @return \Cartalyst\Stripe\Billing\InvoiceItemsGateway
	 */
	public function items()
	{
		return $this->invoiceItems ?: new InvoiceItemsGateway($this->billable);
	}

	/**
	 * Creates a new invoice on the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function create(array $attributes = [])
	{
		// Get the entity stripe id
		$stripeId = $this->billable->stripe_id;

		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$stripeId,
			array_get($attributes, 'customer', [])
		);

		// Get the invoice items for this invoice
		$items = array_get($attributes, 'items', []);
		array_forget($attributes, 'items');

		// Loop through the items and lazily create them
		foreach ($items as $item)
		{
			$this->items()->create($item);
		}

		// Prepare the payload
		$attributes = array_merge($attributes, [
			'customer' => $stripeId,
		]);

		// Create the invoice on Stripe
		$invoice = $this->client->invoices()->create($attributes);

		// Attach the created invoice to the billable entity
		$model = $this->storeInvoice($invoice);

		// Fire the 'cartalyst.stripe.invoice.created' event
		$this->fire('invoice.created', [ $model, $invoice ]);

		return $invoice;
	}

	/**
	 * Updates the given invoice.
	 *
	 * @param  string  $id
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function update($id = null, array $attributes = [])
	{
		// Get the invoice id
		$id = $id ?: $this->invoice->stripe_id;

		// Prepare the payload
		$payload = array_merge($attributes, compact('id'));

		// Update the invoice
		$invoice = $this->client->invoices()->update($payload);

		// Update the invoice on storage
		$model = $this->storeInvoice($invoice);

		// Fire the 'cartalyst.stripe.invoice.updated' event
		$this->fire('invoice.updated', [ $model, $invoice ]);

		return $invoice;
	}

	/**
	 * Pays the given invoice.
	 *
	 * @param  string  $id
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function pay($id = null)
	{
		// Get the invoice id
		$id = $id ?: $this->invoice->stripe_id;

		// Pay the invoice
		$invoice = $this->client->invoices()->pay(compact('id'));

		// Update the invoice on storage
		$model = $this->storeInvoice($invoice);

		// Fire the 'cartalyst.stripe.invoice.paid' event
		$this->fire('invoice.paid', [ $model, $invoice ]);

		return $invoice;
	}

	/**
	 * Syncronizes the Stripe invoices data with the local data.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe()
	{
		// Get the entity object
		$entity = $this->billable;

		// Check if the entity is a stripe customer
		if ( ! $entity->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		// Fetch all this entity invoices
		$invoices = array_reverse($this->client->invoicesIterator([
			'customer' => $entity->stripe_id,
		])->toArray());

		// Loop through the invoices
		foreach ($invoices as $invoice)
		{
			$this->storeInvoice($invoice);
		}
	}

	/**
	 * Prepares the invoice item description.
	 *
	 * @param  string  $type
	 * @param  array  $item
	 * @return string
	 */
	protected function prepareInvoiceItemDescription($type, $item)
	{
		return $type === 'subscription' ? $item['plan']['name'] : $item['description'];
	}

	/**
	 * Stores the invoice information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response  $invoice
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	protected function storeInvoice($invoice)
	{
		$entity = $this->billable;

		$stripeId = $invoice['id'];

		$_invoice = $entity->invoices()->where('stripe_id', $stripeId)->first();

		$data = [
			'stripe_id'       => $stripeId,
			'subscription_id' => $invoice['subscription'],
			'currency'        => $invoice['currency'],
			'description'     => $invoice['description'],
			'subtotal'        => $this->convertToDecimal($invoice['subtotal']),
			'total'           => $this->convertToDecimal($invoice['total']),
			'amount_due'      => $this->convertToDecimal($invoice['amount_due']),
			'attempted'       => (bool) $invoice['attempted'],
			'attempt_count'   => $invoice['attempt_count'],
			'closed'          => (bool) $invoice['closed'],
			'paid'            => (bool) $invoice['paid'],
			'metadata'        => $invoice['metadata'],
			'created_at'      => Carbon::createFromTimestamp($invoice['date']),
			'period_start'    => $this->nullableTimestamp($invoice['period_start']),
			'period_end'      => $this->nullableTimestamp($invoice['period_end']),
		];

		if ( ! $_invoice)
		{
			$_invoice = $entity->invoices()->create($data);
		}
		else
		{
			$_invoice->update($data);
		}

		foreach ($invoice['lines']['data'] as $item)
		{
			$stripeId = $item['id'];

			$_item = $_invoice->items()->where('stripe_id', $stripeId)->first();

			$type = array_get($item, 'type', null);

			$data = [
				'stripe_id'    => $stripeId,
				'currency'     => $item['currency'],
				'type'         => $type,
				'amount'       => $this->convertToDecimal($item['amount']),
				'proration'    => (bool) $item['proration'],
				'description'  => $this->prepareInvoiceItemDescription($type, $item),
				'plan_id'      => array_get($item, 'plan.id', null),
				'quantity'     => array_get($item, 'quantity', null),
				'period_start' => $this->nullableTimestamp(array_get($item, 'period.start', null)),
				'period_end'   => $this->nullableTimestamp(array_get($item, 'period.end', null)),
			];

			if ( ! $_item)
			{
				$_invoice->items()->create($data);
			}
			else
			{
				$_item->update($data);
			}
		}

		return $_invoice;
	}

}
