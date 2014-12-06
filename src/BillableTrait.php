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
use Cartalyst\Stripe\Gateways;
use Cartalyst\Stripe\Api\Models\Customer;
use Cartalyst\Stripe\Api\Exception\NotFoundException;
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
	protected static $cardModel = 'Cartalyst\Stripe\Models\IlluminateCard';

	/**
	 * The Eloquent charge model name.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Models\IlluminateCharge';

	/**
	 * The Eloquent charge refund model name.
	 *
	 * @var string
	 */
	protected static $chargeRefundModel = 'Cartalyst\Stripe\Models\IlluminateChargeRefund';

 	/**
	 * The Eloquent discount model name.
	 *
	 * @var string
	 */
	protected static $discountModel = 'Cartalyst\Stripe\Models\IlluminateDiscount';

	/**
	 * The Eloquent invoice model name.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Models\IlluminateInvoice';

	/**
	 * The Eloquent invoice item model name.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Models\IlluminateInvoiceItem';

	/**
	 * The Eloquent subscription model name.
	 *
	 * @var string
	 */
	protected static $subscriptionModel = 'Cartalyst\Stripe\Models\IlluminateSubscription';

	/**
	 * {@inheritDoc}
	 */
	public function isBillable()
	{
		return (bool) $this->stripe_id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function createStripeCustomer(array $attributes = [])
	{
		return (new Gateways\CustomerGateway($this))->create($attributes);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updateStripeCustomer(array $attributes = [])
	{
		return (new Gateways\CustomerGateway($this))->update($attributes);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleteStripeCustomer()
	{
		return (new Gateways\CustomerGateway($this))->delete();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findOrCreateStripeCustomer(array $attributes = [])
	{
		return (new Gateways\CustomerGateway($this))->findOrCreate($attributes);
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
	public function updateDefaultCard($token, array $attributes = [])
	{
		if ($defaultCard = $this->getDefaultCard())
		{
			try
			{
				$this->card($defaultCard)->delete();
			}
			catch (NotFoundException $e)
			{

			}
		}

		return $this->card()->makeDefault()->create($token, $attributes);
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
	public function discounts()
	{
		return $this->morphMany(static::$discountModel, 'discountable');
	}

	/**
 	 * {@inheritDoc}
 	 */
	public function discount($discount)
	{
		return new Gateways\DiscountGateway($this, $discount);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasActiveDiscount()
	{
		$discount = $this->discounts()->activeDiscount();

		return $discount ? $discount->isValid() : false;
	}

	/**
 	 * {@inheritDoc}
 	 */
	public static function getDiscountModel()
	{
		return static::$discountModel;
	}

	/**
 	 * {@inheritDoc}
 	 */
	public static function setDiscountModel($model)
	{
		static::$discountModel = $model;
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
	// public function syncWithStripe(array $arguments = [])
	// {
	// 	$this->card()->syncWithStripe(
	// 		array_get($arguments, 'charge', [])
	// 	);

	// 	$this->charge()->syncWithStripe(
	// 		array_get($arguments, 'card', [])
	// 	);

	// 	$this->invoice()->syncWithStripe(
	// 		array_get($arguments, 'invoice', [])
	// 	);

	// 	$this->subscription()->syncWithStripe(
	// 		array_get($arguments, 'subscription', [])
	// 	);


	// 	return true;


	// 	# sync this customer discount

	// 	$customer = $this->getStripeClient()->customer($this->stripe_id)->toArray();

	// 	$discount = $customer['discount'];

	// 	# store the coupon

	// 	$_coupon = $discount['coupon'];

	// 	$coupon = \DB::table('stripe_coupons')->where('stripe_id', $_coupon['id'])->first();

	// 	$payload = [
	// 		'stripe_id'          => $_coupon['id'],
	// 		'duration'           => $_coupon['duration'],
	// 		'amount_off'         => $_coupon['amount_off'],
	// 		'percent_off'        => $_coupon['percent_off'],
	// 		'currency'           => $_coupon['currency'],
	// 		'duration_in_months' => $_coupon['duration_in_months'],
	// 		'max_redemptions'    => $_coupon['max_redemptions'],
	// 		'redeem_by'          => $_coupon['redeem_by'],
	// 		'times_redeemed'     => $_coupon['times_redeemed'],
	// 		'valid'              => (bool) $_coupon['valid'],
	// 		// 'metadata'        => $_coupon['metadata'],
	// 	];

	// 	if ( ! $coupon)
	// 	{
	// 		$coupon = \DB::table('stripe_coupons')->insert($payload);
	// 	}
	// 	else
	// 	{
	// 		$coupon = \DB::table('stripe_coupons')->where('stripe_id', $_coupon['id'])->update($payload);
	// 	}

	// 	$coupon = \DB::table('stripe_coupons')->where('stripe_id', $_coupon['id'])->first();

	// 	$payload = [
	// 		'discount_id' => $coupon->id,
	// 		'starts_at' => $discount['start'] ? \Carbon\Carbon::createFromTimestamp($discount['start']) : null,
	// 		'ends_at'   => $discount['end'] ? \Carbon\Carbon::createFromTimestamp($discount['end']) : null,
	// 	];

	// 	$discount = $this->discounts()->where('discount_id', $coupon->id)->first();

	// 	if ( ! $discount)
	// 	{
	// 		$model = $this->getDiscountModel();

	// 		$discount = $this->discounts()->save(new $model($payload));
	// 	}
	// 	else
	// 	{
	// 		$discount->update($payload);
	// 	}
	// }

	/**
	 * {@inheritDoc}
	 */
	// public static function syncStripeCustomers(Closure $callback)
	// {
	// 	// Get all the Stripe Customers
	// 	$customers = static::getStripeClient()->customersIterator();

	// 	foreach ($customers as $customer)
	// 	{
	// 		// Get this customer entity object
	// 		$entity = static::determineCallableEntity($customer, $callback);

	// 		// Synchronize the entity with Stripe
	// 		$entity->syncWithStripe();
	// 	}
	// }

	/**
	 * {@inheritDoc}
	 */
	public function attachStripeCustomer(Customer $customer, $sync = true)
	{
		// Store the Stripe Customer Id
		$this->stripe_id = $customer['id'];
		$this->save();

		// Should we synchronize the entity with Stripe?
		//if ($sync) $this->syncWithStripe();
	}

	/**
	 * {@inheritDoc}
	 */
	# most likely to remove this as well, the attachStripeCustomer can
	# stay as it's kinda usefull
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
	 * @return \Cartalyst\Stripe\BillableInterface
	 * @throws \InvalidArgumentException
	 */
	protected static function determineCallableEntity($customer, Closure $callback)
	{
		$entity = call_user_func($callback, $customer);

		if ($entity instanceof BillableInterface) return $entity;

		throw new \InvalidArgumentException(
			"The billable entity for the customer [{$customer['id']}] wasn't properly returned!"
		);
	}

}
