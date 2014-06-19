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
	 * Returns all the cards attached to this entity.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	public function cards();

	/**
	 * Returns a new Stripe Card gateway.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\CardGateway
	 */
	public function card($card = null);

	/**
	 * Returns all the charges that this entity has made.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateCharge
	 */
	public function charges();

	/**
	 * Returns a new Stripe Charge gateway.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\ChargeGateway
	 */
	public function charge($charge = null);

	/**
	 * Returns all the subscriptions that this entity has.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function subscriptions();

	/**
	 * Returns a new Stripe Subscription gateway.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\SubscriptionGateway
	 */
	public function subscription($subscription = null);

	/**
	 * Checks if the entity currently has any active subscriptions.
	 *
	 * @return bool
	 */
	public function isSubscribed();

	/**
	 * Checks if the entity has any active card.
	 *
	 * @return bool
	 */
	public function hasActiveCard();

	/**
	 * Apply a coupon to the billable entity.
	 *
	 * @param  string  $coupon
	 * @return array
	 */
	public function applyCoupon($coupon);

	/**
	 * Update the default credit card attached to the entity.
	 *
	 * @param  string  $token
	 * @return array
	 */
	public function updateDefaultCard($token);

	/**
	 * Returns the Stripe ID for the entity.
	 *
	 * @return string
	 */
	public function getStripeId();

	/**
	 * Syncronizes the Stripe data with the local data.
	 *
	 * @return void
	 */
	public function syncWithStripe();

}
