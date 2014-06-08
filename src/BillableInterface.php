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

interface BillableInterface {

	/**
	 * Returns a new Stripe Card gateway.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\Card\CardGateway
	 */
	public function card($card = null);

	/**
	 * Returns all the cards attached to this user.
	 *
	 * @return \Cartalyst\Stripe\Card\IlluminateCard
	 */
	public function cards();

	/**
	 * Update the default credit card attached to the entity.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function updateDefaultCard($token);

	/**
	 * Returns a new Stripe Charge gateway.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\Charge\ChargeGateway
	 */
	public function charge($charge = null);

	/**
	 * Returns all the charges that this user has made.
	 *
	 * @return \Cartalyst\Stripe\Charge\IlluminateCharge
	 */
	public function charges();

	/**
	 * Returns a new Stripe Subscription gateway.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function subscription($subscription = null);

	/**
	 * Returns all the subscriptions that this user has.
	 *
	 * @return \Cartalyst\Stripe\Subscription\IlluminateSubscription
	 */
	public function subscriptions();

	/**
	 * Checks if the user currently has any active subscriptions.
	 *
	 * @return bool
	 */
	public function isSubscribed();

	/**
	 * Checks if the user has any active card.
	 *
	 * @return bool
	 */
	public function hasActiveCard();

	/**
	 * Apply a coupon to the billable entity.
	 *
	 * @param  string  $coupon
	 * @return void
	 */
	public function applyCoupon($coupon);

	/**
	 * Returns the Stripe ID for the entity.
	 *
	 * @return string
	 */
	public function getStripeId();

	/**
	 * Returns the Stripe customer object.
	 *
	 * @return \Stripe_Customer
	 */
	public function getStripeCustomer();

	/**
	 * Returns the Stripe API key.
	 *
	 * @return string
	 */
	public static function getStripeKey();

	/**
	 * Sets the Stripe API key.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public static function setStripeKey($key);

	/**
	 * Syncronizes the Stripe data with the local data.
	 *
	 * @return void
	 */
	public function syncWithStripe();

}
