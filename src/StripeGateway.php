<?php namespace Cartalyst\Stripe;
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

use Stripe;
use Stripe_Customer;

class StripeGateway {

	/**
	 * The billable instance.
	 *
	 * @var \Cartalyst\Stripe\BillableInterface
	 */
	protected $billable;

	/**
	 * Create a new Stripe gateway instance.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @return void
	 */
	public function __construct(BillableInterface $billable)
	{
		$this->billable = $billable;

		Stripe::setApiKey($this->getStripeKey());
	}

	/**
	 * Create a new Stripe customer.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return \Stripe_Customer
	 */
	public function createStripeCustomer($token, array $attributes = [])
	{
		$attributes = array_merge($attributes, ['card' => $token]);

		$customer = Stripe_Customer::create($attributes, $this->getStripeKey());

		$card = $customer->cards->retrieve($customer->default_card);

		$this->billable->cards()->create([
			'stripe_id' => $card->id,
			'last_four' => $card->last4,
			'exp_month' => $card->exp_month,
			'exp_year'  => $card->exp_year,
			'default'   => true,
		]);

		return $customer;
	}

	/**
	 * Updates the Stripe customer.
	 *
	 * @param  string  $id
	 * @param  array  $attributes
	 * @return \Stripe_Customer
	 */
	public function updateStripeCustomer($id, array $attributes = [])
	{
		$customer = $this->getStripeCustomer($id);

		foreach ($attributes as $key => $value)
		{
			$customer->{$key} = $value;
		}

		$customer->save();

		return $customer;
	}

	/**
	 * Returns the Stripe customer for entity.
	 *
	 * @param  string  $id
	 * @return \Stripe_Customer
	 */
	public function getStripeCustomer($id = null)
	{
		return Stripe_Customer::retrieve(
			$id ?: $this->billable->getStripeId(),
			$this->getStripeKey()
		);
	}

	/**
	 * Update the local Stripe data in storage.
	 *
	 * @param  \Stripe_Customer  $customer
	 * @return void
	 */
	public function updateLocalStripeData($customer)
	{
		$entity = $this->billable;

		if ($customer->cards->total_count > 1)
		{
			$card = $customer->cards->retrieve($customer->default_card);

			$entity
				->cards()
				->where('default', 1)
				->update(['default' => 0]);

			$entity
				->cards()
				->where('stripe_id', $card->id)
				->update(['default' => 1]);
		}

		$entity->stripe_id = $customer->id;
		$entity->save();
	}

	/**
	 * Get the Stripe API key for the instance.
	 *
	 * @return string
	 */
	protected function getStripeKey()
	{
		return $this->billable->getStripeKey();
	}

}
