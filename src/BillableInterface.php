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

use Closure;
use Cartalyst\Stripe\Api\Stripe;
use Cartalyst\Stripe\Api\Models\Customer;

interface BillableInterface {

	/**
	 * Determines if the entity is a Stripe customer.
	 *
	 * @return bool
	 */
	public function isBillable();

	/**
	 * Creates a Stripe customer that will be attached to the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function createStripeCustomer(array $attributes = []);

	/**
	 * Updates the entity Stripe customer.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function updateStripeCustomer(array $attributes = []);

	/**
	 * Deletes the entity Stripe customer and all it's relevant data from storage.
	 *
	 * @return bool
	 */
	public function deleteStripeCustomer();

	/**
	 * Finds or creates a Stripe customer that is attached to the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function findOrCreateStripeCustomer(array $attributes = []);

	/**
	 * Returns the entity Eloquent card model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	public function cards();

	/**
	 * Returns a Stripe Card gateway instance.
	 *
	 * @param  mixed  $card
	 * @return \Cartalyst\Stripe\Gateways\CardGateway
	 */
	public function card($card = null);

	/**
	 * Returns the Eloquent card model name.
	 *
	 * @return string
	 */
	public static function getCardModel();

	/**
	 * Sets the Eloquent card model name.
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
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	public function getDefaultCard();

	/**
	 * Updates the default credit card attached to the entity.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return array
	 */
	public function updateDefaultCard($token, array $attributes = []);

	/**
	 * Returns the entity Eloquent charge model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateCharge
	 */
	public function charges();

	/**
	 * Returns a Stripe Charge gateway instance.
	 *
	 * @param  mixed  $charge
	 * @return \Cartalyst\Stripe\Gateways\ChargeGateway
	 */
	public function charge($charge = null);

	/**
	 * Returns the Eloquent charge model name.
	 *
	 * @return string
	 */
	public static function getChargeModel();

	/**
	 * Sets the Eloquent charge model name.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeModel($model);

	/**
	 * Returns the Eloquent charge refund model name.
	 *
	 * @return string
	 */
	public static function getChargeRefundModel();

	/**
	 * Sets the Eloquent charge refund model name.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeRefundModel($model);

 	/**
	 * Returns the entity Eloquent discount model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateDiscount
	 */
	public function discounts();

	/**
	 * Returns the entity Eloquent invoice model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateInvoice
	 */
	public function invoices();

	/**
	 * Returns a Stripe Invoice gateway instance.
	 *
	 * @param  mixed  $invoice
	 * @return \Cartalyst\Stripe\Gateways\InvoiceGateway
	 */
	public function invoice($invoice = null);

	/**
	 * Returns the entity Eloquent invoice items model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateInvoiceItem
	 */
	public function invoiceItems();

	/**
	 * Returns the upcoming invoice items.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function upcomingInvoice();

	/**
	 * Returns the Eloquent invoice model name.
	 *
	 * @return string
	 */
	public static function getInvoiceModel();

	/**
	 * Sets the Eloquent invoice model name.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceModel($model);

	/**
	 * Returns the Eloquent invoice items model name.
	 *
	 * @return string
	 */
	public static function getInvoiceItemModel();

	/**
	 * Sets the Eloquent invoice items model name.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceItemModel($model);

	/**
	 * Returns the entity Eloquent subscription model object.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function subscriptions();

	/**
	 * Returns a Stripe Subscription gateway instance.
	 *
	 * @param  mixed  $subscription
	 * @return \Cartalyst\Stripe\Gateways\SubscriptionGateway
	 */
	public function subscription($subscription = null);

	/**
	 * Returns the Eloquent subscription model name.
	 *
	 * @return string
	 */
	public static function getSubscriptionModel();

	/**
	 * Sets the Eloquent subscription model name.
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
	 * Syncronizes the Stripe data with the local data.
	 *
	 * @param  array  $arguments
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	// public function syncWithStripe(array $arguments = []);

	/**
	 * Syncronizes all the Stripe customers with the local data.
	 *
	 * @param  \Closure  $callback
	 * @return void
	 */
	// public static function syncStripeCustomers(Closure $callback);

	/**
	 * Attaches the Stripe Customer account to the entity, it allows
	 * you to syncronize the Stripe data for that entity by passing
	 * by passing a boolean of true as the second parameter.
	 *
	 * @param  \Cartalyst\Stripe\Api\Models\Customer  $customer
	 * @param  bool  $sync
	 * @return void
	 */
	public function attachStripeCustomer(Customer $customer, $sync = true);

	/**
	 * Attaches the Stripe Customers accounts to the entity that will be
	 * returned from the given callback, allowing you to syncronize the
	 * Stripe data for that entity by just passing a boolean of true
	 * as the second parameter.
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
