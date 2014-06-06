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

use Cartalyst\Stripe\Charge\ChargeGateway;
use Cartalyst\Stripe\Subscription\SubscriptionGateway;
use Illuminate\Support\Facades\Config;

trait BillableTrait {

	/**
	 * The Stripe gateway instance.
	 *
	 * @var \Cartalyst\Stripe\StripeGateway
	 */
	protected $gateway = null;

	/**
	 * The Stripe Customer instance.
	 *
	 * @var \Stripe_Customer
	 */
	protected $customer = null;

	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected static $stripeKey;

	/**
	 * Returns a new Stripe Card gateway.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\Card\CardGateway
	 */
	public function card($card = null)
	{
		return new CardGateway($this, $card);
	}

	/**
	 * Returns all the cards attached to this user.
	 *
	 * @return \Cartalyst\Stripe\Card\IlluminateCard
	 */
	public function cards()
	{
		return $this->hasMany('Cartalyst\Stripe\Card\IlluminateCard');
	}

	/**
	 * Returns a new Stripe Charge gateway.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\Charge\ChargeGateway
	 */
	public function charge($charge = null)
	{
		return new ChargeGateway($this, $charge);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updateDefaultCard($token)
	{
		$customer = $this->getStripeCustomer();
		$customer->card = $token;
		$customer->save();

		$this->last_four = $customer->cards->retrieve($customer->default_card)->last4;
		$this->save();
	}

	/**
	 * Returns all the charges that this user has made.
	 *
	 * @return \Cartalyst\Stripe\Charge\IlluminateCharge
	 */
	public function charges()
	{
		return $this->hasMany('Cartalyst\Stripe\Charge\IlluminateCharge');
	}

	/**
	 * Returns a new Stripe Subscription gateway.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function subscription($subscription = null)
	{
		return new SubscriptionGateway($this, $subscription);
	}

	/**
	 * Returns all the subscriptions that this user has.
	 *
	 * @return \Cartalyst\Stripe\Subscription\IlluminateSubscription
	 */
	public function subscriptions()
	{
		return $this->hasMany('Cartalyst\Stripe\Subscription\IlluminateSubscription');
	}

	/**
	 * Checks if the user currently has any active subscriptions.
	 *
	 * @return bool
	 */
	public function isSubscribed()
	{
		return (bool) $this->subscriptions()->whereActive(1)->count();
	}

	/**
	 * Checks if the user has any active card.
	 *
	 * @return bool
	 */
	public function hasActiveCard()
	{
		return (bool) $this->cards->count();
	}

	/**
	 * {@inheritDoc}
	 */
	public function applyCoupon($coupon)
	{
		$customer = $this->getStripeCustomer();

		$customer->coupon = $coupon;

		$customer->save();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStripeId()
	{
		return $this->stripe_id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStripeCustomer()
	{
		return $this->customer ?: $this->gateway()->getStripeCustomer();
	}

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

	/**
	 * Returns the Stripe gateway.
	 *
	 * @return \Cartalyst\Stripe\StripeGateway
	 */
	protected function gateway()
	{
		return $this->gateway ?: new StripeGateway($this);
	}

}
