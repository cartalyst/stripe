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

class InvoiceItemsGateway extends StripeGateway {

	/**
	 * Creates a new invoice item on the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function create(array $attributes = [])
	{
		// Get the entity object
		$entity = $this->billable;

		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$entity->stripe_id,
			array_get($attributes, 'customer', [])
		);

		// Prepare the payload
		$attributes = array_merge($attributes, [
			'customer' => $entity->stripe_id,
		]);

		// Create the invoice item on Stripe
		$item = $this->client->invoiceItems()->create($attributes);

		// Fire the 'cartalyst.stripe.invoice_item.created' event
		$this->fire('invoice_item.created', [ $item ]);

		return $item;
	}

	/**
	 * Updates the given invoice item on the entity.
	 *
	 * @param  string  $id
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function update($id, array $attributes = [])
	{
		// Prepare the payload
		$payload = array_merge($attributes, compact('id'));

		// Delete the invoice item on Stripe
		$item = $this->client->invoiceItems()->update($payload);

		// Fire the 'cartalyst.stripe.invoice_item.updated' event
		$this->fire('invoice_item.updated', [ $item ]);

		return $item;
	}

	/**
	 * Deletes the given invoice item on the entity.
	 *
	 * @param  string  $id
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function delete($id)
	{
		// Delete the invoice item on Stripe
		$item = $this->client->invoiceItems()->destroy(compact('id'));

		// Fire the 'cartalyst.stripe.invoice_item.deleted' event
		$this->fire('invoice_item.deleted', [ $item ]);

		return $item;
	}

}
