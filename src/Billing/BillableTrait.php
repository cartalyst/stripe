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
use Cartalyst\Stripe\Billing\Gateways;
use Cartalyst\Stripe\Api\Models\Customer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait BillableTrait {

	/**
	 * The Stripe API instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected static $stripeClient;

	/**
	 * The Eloquent card model name.
	 *
	 * @var string
	 */
	protected static $cardModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCard';

	/**
	 * The Eloquent charge model name.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCharge';

	/**
	 * The Eloquent charge refund model name.
	 *
	 * @var string
	 */
	protected static $chargeRefundModel = 'Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund';

	/**
	 * The Eloquent invoice model name.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoice';

	/**
	 * The Eloquent invoice item model name.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem';

	/**
	 * The Eloquent subscription model name.
	 *
	 * @var string
	 */
	protected static $subscriptionModel = 'Cartalyst\Stripe\Billing\Models\IlluminateSubscription';

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
	public function isBillable()
	{
		return (bool) $this->getStripeId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function cards()
	{
		return $this->morphMany(static::$cardModel, 'billable');
	}

	/**
	 * {@inheritDoc}
	 */
	public function card($card = null)
	{
		return new Gateways\CardGateway($this, $card);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getCardModel()
	{
		return static::$cardModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setCardModel($model)
	{
		static::$cardModel = $model;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasActiveCard()
	{
		return (bool) $this->cards->count();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDefaultCard()
	{
		return $this->cards()->whereDefault(1)->first();
	}

	/**
	 * {@inheritDoc}
	 */
	public function updateDefaultCard($token)
	{
		return $this->card()->makeDefault()->create($token);
	}

	/**
	 * {@inheritDoc}
	 */
	public function charges()
	{
		return $this->morphMany(static::$chargeModel, 'billable');
	}

	/**
	 * {@inheritDoc}
	 */
	public function charge($charge = null)
	{
		return new Gateways\ChargeGateway($this, $charge);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getChargeModel()
	{
		return static::$chargeModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setChargeModel($model)
	{
		static::$chargeModel = $model;

		forward_static_call_array([ static::$chargeRefundModel, 'setChargeModel' ], [ $model ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getChargeRefundModel()
	{
		return static::$chargeRefundModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setChargeRefundModel($model)
	{
		static::$chargeRefundModel = $model;

		forward_static_call_array([ static::$chargeModel, 'setRefundModel' ], [ $model ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoices()
	{
		return $this->morphMany(static::$invoiceModel, 'billable');
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoice($invoice = null)
	{
		return new Gateways\InvoiceGateway($this, $invoice);
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoiceItems()
	{
		return $this->morphMany(static::$invoiceItemModel, 'billable');
	}

	/**
	 * {@inheritDoc}
	 */
	public function upcomingInvoice()
	{
		return $this->invoiceItems()->where('invoice_id', 0)->get();
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getInvoiceModel()
	{
		return static::$invoiceModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setInvoiceModel($model)
	{
		static::$invoiceModel = $model;

		forward_static_call_array([ static::$chargeModel, 'setInvoiceModel' ], [ $model ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getInvoiceItemModel()
	{
		return static::$invoiceItemModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setInvoiceItemModel($model)
	{
		static::$invoiceItemModel = $model;

		forward_static_call_array([ static::$invoiceModel, 'setInvoiceItemModel' ], [ $model ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function subscriptions()
	{
		return $this->morphMany(static::$subscriptionModel, 'billable');
	}

	/**
	 * {@inheritDoc}
	 */
	public function subscription($subscription = null)
	{
		return new Gateways\SubscriptionGateway($this, $subscription);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getSubscriptionModel()
	{
		return static::$subscriptionModel;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setSubscriptionModel($model)
	{
		static::$subscriptionModel = $model;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSubscribed()
	{
		return (bool) $this->subscriptions()->whereActive(1)->count();
	}

	/**
	 * {@inheritDoc}
	 */
	public function applyCoupon($coupon)
	{
		return $this->getStripeClient()->customers()->update([
			'id'     => $this->getStripeId(),
			'coupon' => $coupon,
		]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function syncWithStripe(array $arguments = [])
	{
		if ( ! $this->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		$this->card()->syncWithStripe(
			array_get($arguments, 'charge', [])
		);

		$this->charge()->syncWithStripe(
			array_get($arguments, 'card', [])
		);

		$this->invoice()->syncWithStripe(
			array_get($arguments, 'invoice', [])
		);

		$this->subscription()->syncWithStripe(
			array_get($arguments, 'subscription', [])
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function syncStripeCustomers(Closure $callback)
	{
		// Get all the Stripe Customers
		$customers = static::getStripeClient()->customersIterator();

		foreach ($customers as $customer)
		{
			// Get this customer entity object
			$entity = static::determineCallableEntity($customer, $callback);

			// Synchronize the entity with Stripe
			$entity->syncWithStripe();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function attachStripeCustomer(Customer $customer, $sync = true)
	{
		// Store the Stripe Customer Id
		$this->stripe_id = $customer['id'];
		$this->save();

		// Should we synchronize the entity with Stripe?
		if ($sync) $this->syncWithStripe();
	}

	/**
	 * {@inheritDoc}
	 */
	public static function attachStripeCustomers(Closure $callback, $sync = true)
	{
		// Get all the Stripe Customers
		$customers = static::getStripeClient()->customersIterator();

		// Loop through the Stripe Customers
		foreach ($customers as $customer)
		{
			// Get this customer entity object
			$entity = static::determineCallableEntity($customer, $callback);

			// Store the Stripe Customer Id
			$entity->stripe_id = $customer['id'];
			$entity->save();

			// Should we synchronize the entity with Stripe?
			if ($sync) $entity->syncWithStripe();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getStripeClient()
	{
		return static::$stripeClient;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setStripeClient(Stripe $stripe)
	{
		static::$stripeClient = $stripe;
	}

	/**
	 * Returns the callable entity object.
	 *
	 * @param  array|\Cartalyst\Stripe\Api\Models\Customer  $customer
	 * @param  \Closure  $callback
	 * @return \Cartalyst\Stripe\Billing\BillableInterface
	 * @throws \InvalidArgumentException
	 */
	protected static function determineCallableEntity($customer, Closure $callback)
	{
		$entity = call_user_func($callback, $customer);

		if ($entity instanceof BillableInterface) return $entity;

		throw new \InvalidArgumentException("The billable entity for the customer [{$customer['id']}] wasn't returned!");
	}

}
