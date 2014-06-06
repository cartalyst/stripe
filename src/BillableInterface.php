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
	 * Returns a new billing builder instance for the given plan.
	 *
	 * @param  \Cartalyst\Stripe\PlanInterface|string|null  $plan
	 * @return \Cartalyst\Stripe\Builder
	 */
	#public function subscription($plan = null);

	/**
	 * Update the default credit card attached to the entity.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function updateDefaultCard($token);

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

}
