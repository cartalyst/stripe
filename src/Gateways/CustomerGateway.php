<?php namespace Cartalyst\Stripe\Gateways;
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

use Cartalyst\Stripe\Api\Exception\NotFoundException;

class CustomerGateway extends AbstractGateway {

	/**
	 * Finds the entity Stripe customer.
	 *
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function find()
	{
		return $this->client->customers()->find([
			'id' => (string) $this->billable->stripe_id,
		]);
	}

	/**
	 * Creates a new Stripe customer for the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function create(array $attributes = [])
	{
		$customer = $this->client->customers()->create($attributes);

		$this->billable->stripe_id = $customer['id'];
		$this->billable->save();

		return $customer;
	}

	/**
	 * Updates the entity Stripe customer.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function update(array $attributes = [])
	{
		return $this->client->customers()->update(array_merge($attributes, [
			'id' => $this->billable->stripe_id,
		]));
	}

	/**
	 * Deletes the entity Stripe customer and all it's relevant data from storage.
	 *
	 * @return bool
	 */
	public function delete()
	{
		$entity = $this->billable;

		$this->client->customers()->destroy([
			'id' => $entity->stripe_id,
		]);

		$entity->cards()->delete();

		$entity->charges()->delete();

		# delete all the applied discounts
		// $entity->discounts()->delete();

		$entity->invoices()->delete();

		$entity->subscriptions()->delete();

		$entity->stripe_id = null;
		$entity->save();

		return true;
	}

	/**
	 * Finds or creates a new Stripe customer for the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function findOrCreate(array $attributes = [])
	{
		try
		{
			return $this->find();
		}
		catch (NotFoundException $e)
		{
			return $this->create($attributes);
		}
	}

}
