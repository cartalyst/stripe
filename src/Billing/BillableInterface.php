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

interface BillableInterface {

	/**
	 * Returns the entity Stripe ID.
	 *
	 * @return string
	 */
	public function getStripeId();

	/**
	 * Determines if the entity is a Stripe customer.
	 *
	 * @return bool
	 */
	public function isBillable();

	/**
	 * Returns the entity Eloquent card model object.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	public function cards();

	/**
	 * Returns a new Stripe Card gateway.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\Billing\CardGateway
	 */
	public function card($card = null);

	/**
	 * Sets the Eloquent card model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setCardModel($model);

	/**
	 * Checks if the entity has any active card.
	 *
	 * @return bool
	 */
	public function hasActiveCard();

	/**
	 * Returns the entity default card.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	public function getDefaultCard();

	/**
	 * Updates the default credit card attached to the entity.
	 *
	 * @param  string  $token
	 * @return array
	 */
	public function updateDefaultCard($token);

	/**
	 * Returns the entity Eloquent charge model object.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function charges();

	/**
	 * Returns a new Stripe Charge gateway.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\Billing\ChargeGateway
	 */
	public function charge($charge = null);

	/**
	 * Sets the Eloquent charge model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeModel($model);

	/**
	 * Sets the Eloquent charge refund model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeRefundModel($model);

	/**
	 * Returns the entity Eloquent invoice model object.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	public function invoices();

	/**
	 * Returns a new Stripe Invoice gateway.
	 *
	 * @param  mixed  $invoice
	 * @return \Cartalyst\Stripe\Billing\InvoiceGateway
	 */
	public function invoice($invoice = null);

	/**
	 * Returns the entity Eloquent invoice items model object.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
	 */
	public function invoiceItems();

	/**
	 * Sets the Eloquent invoice model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceModel($model);

	/**
	 * Sets the Eloquent invoice items model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceItemModel($model);

	/**
	 * Returns the entity Eloquent subscription model object.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function subscriptions();

	/**
	 * Returns a new Stripe Subscription gateway.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function subscription($subscription = null);

	/**
	 * Sets the Eloquent subscription model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setSubscriptionModel($model);

	/**
	 * Checks if the entity has any active subscriptions.
	 *
	 * @return bool
	 */
	public function isSubscribed();

	/**
	 * Applies a coupon to the entity.
	 *
	 * @param  string  $coupon
	 * @return array
	 */
	public function applyCoupon($coupon);

	/**
	 * Syncronizes the Stripe data with the local data.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe();

}
