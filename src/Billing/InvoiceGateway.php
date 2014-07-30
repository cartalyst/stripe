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
	 * The Eloquent invoice object.
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
		$this->storeInvoice($invoice);

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
		$this->storeInvoice($invoice);

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
		$response = $this->client->invoices()->pay(compact('id'));

		// Disable the event dispatcher
		$this->disableEventDispatcher();

		// Update the invoice on storage
		$invoice = $this->storeInvoice($response);

		// Enable the event dispatcher
		$this->enableEventDispatcher();

		// Fire the 'cartalyst.stripe.invoice.paid' event
		$this->fire('invoice.paid', [ $response, $invoice ]);

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

		// Get all the entity invoices
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
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	protected function storeInvoice($response)
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the invoice id
		$stripeId = $response['id'];

		// Find the invoice on storage
		$invoice = $entity->invoices()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $invoice ? 'created' : 'updated';

		// Prepare the payload
		$payload = [
			'stripe_id'       => $stripeId,
			'subscription_id' => $response['subscription'],
			'currency'        => $response['currency'],
			'description'     => $response['description'],
			'subtotal'        => $this->convertToDecimal($response['subtotal']),
			'total'           => $this->convertToDecimal($response['total']),
			'amount_due'      => $this->convertToDecimal($response['amount_due']),
			'attempted'       => (bool) $response['attempted'],
			'attempt_count'   => $response['attempt_count'],
			'closed'          => (bool) $response['closed'],
			'paid'            => (bool) $response['paid'],
			'metadata'        => $response['metadata'],
			'created_at'      => Carbon::createFromTimestamp($response['date']),
			'period_start'    => $this->nullableTimestamp($response['period_start']),
			'period_end'      => $this->nullableTimestamp($response['period_end']),
		];

		// Does the invoice exist on storage?
		if ( ! $invoice)
		{
			$invoice = $entity->invoices()->create($payload);
		}
		else
		{
			$invoice->update($payload);
		}

		// Fires the appropriate event
		$this->fire("invoice.{$event}", [ $response, $invoice ]);

		// Loop through the invoice items
		foreach ($response['lines']['data'] as $item)
		{
			$this->storeInvoiceItem($invoice, $item);
		}

		return $invoice;
	}

	/**
	 * Stores the invoice item information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Billing\Models\IlluminateInvoice  $invoice
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
	 */
	protected function storeInvoiceItem(IlluminateInvoice $invoice, $response)
	{
		// Get the invoice item id
		$stripeId = $response['id'];

		// Find the invoice item on storage
		$item = $invoice->items()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $item ? 'created' : 'updated';

		// Get the invoice item type
		$type = array_get($response, 'type', null);

		// Prepare the payload
		$payload = [
			'stripe_id'    => $stripeId,
			'currency'     => $response['currency'],
			'type'         => $type,
			'amount'       => $this->convertToDecimal($response['amount']),
			'proration'    => (bool) $response['proration'],
			'description'  => $this->prepareInvoiceItemDescription($type, $response),
			'plan_id'      => array_get($response, 'plan.id', null),
			'quantity'     => array_get($response, 'quantity', null),
			'period_start' => $this->nullableTimestamp(array_get($response, 'period.start', null)),
			'period_end'   => $this->nullableTimestamp(array_get($response, 'period.end', null)),
		];

		// Does the invoice item exist on storage?
		if ( ! $item)
		{
			$invoice->items()->create($payload);
		}
		else
		{
			$item->update($payload);
		}

		// Fires the appropriate event
		$this->fire("invoice.item.{$event}", [ $response, $item ]);

		return $item;
	}

}
