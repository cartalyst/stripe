<?php namespace Cartalyst\Stripe;

use Config;

trait BillableTrait {


	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected static $stripeKey;

	/**
	 * {@inheritDoc}
	 */
	public static function getStripeKey()
	{
		return static::$stripeKey ?: Config::get('services.stripe.secret');
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setStripeKey($key)
	{
		static::$stripeKey = $key;
	}


	public function customer()
	{
		return new StripeCustomer($this);
	}


}
