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

use Closure;
use Cartalyst\Stripe\Api\Stripe;

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
	 * Returns a Stripe Card gateway instance.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\Billing\CardGateway
	 */
	public function card($card = null);

	/**
	 * Returns the Eloquent card model.
	 *
	 * @return string
	 */
	public static function getCardModel();

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
	 * Returns a Stripe Charge gateway instance.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\Billing\ChargeGateway
	 */
	public function charge($charge = null);

	/**
	 * Returns the Eloquent charge model.
	 *
	 * @return string
	 */
	public static function getChargeModel();

	/**
	 * Sets the Eloquent charge model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeModel($model);

	/**
	 * Returns the Eloquent charge refund model.
	 *
	 * @return string
	 */
	public static function getChargeRefundModel();

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
	 * Returns a Stripe Invoice gateway instance.
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
	 * Returns the upcoming invoice items.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function upcomingInvoice();

	/**
	 * Returns the Eloquent invoice model.
	 *
	 * @return string
	 */
	public static function getInvoiceModel();

	/**
	 * Sets the Eloquent invoice model.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceModel($model);

	/**
	 * Returns the Eloquent invoice items model.
	 *
	 * @return string
	 */
	public static function getInvoiceItemModel();

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
	 * Returns a Stripe Subscription gateway instance.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function subscription($subscription = null);

	/**
	 * Returns the Eloquent subscription model.
	 *
	 * @return string
	 */
	public static function getSubscriptionModel();

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

	/**
	 * Attaches the Stripe Customer account to the entity,
	 * it allows you to syncronize the Stripe data for
	 * that entity by passing a boolean of true as
	 * the third parameter.
	 *
	 * @param  array  $data
	 * @param  bool  $sync
	 * @return void
	 */
	public function attachStripeCustomer(array $data, $sync = true);

	/**
	 * Attaches the Stripe Customers accounts to the entity that
	 * will be returned from the Closure, it allows you to
	 * syncronize the Stripe data for that entity by just
	 * passing a boolean of true as the third parameter.
	 *
	 * @param  \Closure  $callback
	 * @param  bool  $sync
	 * @return void
	 */
	public static function attachStripeCustomers(Closure $callback, $sync = true);

	/**
	 * Returns the Stripe API instance.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	public static function getStripeClient();

	/**
	 * Sets the Stripe API instance.
	 *
	 * @param  \Cartalyst\Stripe\Api\Stripe  $stripe
	 * @return void
	 */
	public static function setStripeClient(Stripe $stripe);

}
