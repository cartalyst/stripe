<?php namespace Cartalyst\Stripe\Billing\Gateways;
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

use Closure;
use Cartalyst\Stripe\Billing\BillableInterface;
use Cartalyst\Stripe\Api\Exception\NotFoundException;
use Cartalyst\Stripe\Billing\Models\IlluminateInvoice;
use Cartalyst\Stripe\Billing\Gateways\InvoiceItemsGateway;
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
	 * @var \Cartalyst\Stripe\Billing\Gateways\InvoiceItemsGateway
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
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	public function create(array $attributes = [])
	{
		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$this->billable->stripe_id,
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
			'customer' => $this->billable->stripe_id,
		]);

		// Create the invoice on Stripe
		$response = $this->client->invoices()->create($attributes);

		// Attach the created invoice to the billable entity
		return $this->storeInvoice($response);
	}

	/**
	 * Updates the given invoice.
	 *
	 * @param  string  $id
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	public function update($id = null, array $attributes = [])
	{
		// Get the invoice id
		$id = $id ?: $this->invoice->stripe_id;

		// Prepare the payload
		$payload = array_merge($attributes, compact('id'));

		// Update the invoice
		$response = $this->client->invoices()->update($payload);

		// Update the invoice on storage
		return $this->storeInvoice($response);
	}

	/**
	 * Pays the given invoice.
	 *
	 * @param  string  $id
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
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
	 * @param  array  $arguments
	 * @param  \Closure  $callback
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe(array $arguments = [], Closure $callback = null)
	{
		// Get the entity object
		$entity = $this->billable;

		// Check if the entity is a stripe customer
		if ( ! $entity->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		// Prepare the expand array
		$expand = array_get($arguments, 'expand', []);
		foreach ($expand as $key => $value)
		{
			$expand[$key] = "data.{$value}";
		}
		array_set($arguments, 'expand', $expand);

		// Prepare the payload
		$payload = array_merge($arguments, [
			'customer' => $entity->stripe_id,
		]);

		// Remove the "callback" from the arguments, this is passed
		// through the main syncWithStripe method, so we remove it
		// here anyways so that we can have a proper payload.
		$callback = array_get($payload, 'callback', $callback);
		array_forget($payload, 'callback');

		// Get all the entity invoices
		$invoices = array_reverse($this->client->invoicesIterator($payload)->toArray());

		// Loop through the invoices
		foreach ($invoices as $invoice)
		{
			$this->storeInvoice($invoice, $callback);
		}

		// Array that will hold the pending invoice items
		$stripeItems = [];

		try
		{
			// Retrieve the upcoming invoice items
			$upcomingInvoice = $this->client->invoices()->upcomingInvoice([
				'customer' => $entity->stripe_id,
			])->toArray();

			// Loop through the invoices
			foreach ($upcomingInvoice['lines']['data'] as $item)
			{
				$this->items()->storeItem($item);

				$stripeItems[$item['id']] = $item;
			}
		}
		catch (NotFoundException $e)
		{

		}

		// Loop through the current pending invoice items that are
		// on storage and verify if they still exist on Stripe,
		// if they don't exist, we'll delete them from local
		// storage, this is to make sure that the pending
		// invoice items are completely in sync.
		foreach ($entity->upcomingInvoice() as $item)
		{
			if ( ! array_get($stripeItems, $item->stripe_id))
			{
				$item->delete();
			}
		}
	}

	/**
	 * Stores the invoice information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @param  \Closure  $callback
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	protected function storeInvoice($response, Closure $callback = null)
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
			'stripe_id'            => $stripeId,
			'subscription_id'      => $response['subscription'],
			'currency'             => $response['currency'],
			'description'          => $response['description'],
			'subtotal'             => $this->convertToDecimal($response['subtotal']),
			'total'                => $this->convertToDecimal($response['total']),
			'application_fee'      => $this->nullableTimestamp($response['application_fee']),
			'amount_due'           => $this->convertToDecimal($response['amount_due']),
			'attempted'            => (bool) $response['attempted'],
			'attempt_count'        => $response['attempt_count'],
			'closed'               => (bool) $response['closed'],
			'paid'                 => (bool) $response['paid'],
			'metadata'             => $response['metadata'],
			'created_at'           => $this->nullableTimestamp($response['date']),
			'period_start'         => $this->nullableTimestamp($response['period_start']),
			'period_end'           => $this->nullableTimestamp($response['period_end']),
			'next_payment_attempt' => $this->nullableTimestamp($response['next_payment_attempt']),
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

		if ($callback)
		{
			call_user_func($callback, $response, $invoice);
		}

		// Fires the appropriate event
		$this->fire("invoice.{$event}", [ $response, $invoice ]);

		// Loop through the invoice items
		foreach ($response['lines']['data'] as $item)
		{
			$this->items()->storeItem($item, $invoice);
		}

		return $invoice;
	}

}
