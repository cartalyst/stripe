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
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait BillableTrait {

	/**
	 * The Stripe gateway instance.
	 *
	 * @var \Cartalyst\Stripe\Billing\StripeGateway
	 */
	protected $gateway;

	/**
	 * The Stripe API instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected static $stripeClient;

	/**
	 * The Eloquent card model.
	 *
	 * @var string
	 */
	protected static $cardModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCard';

	/**
	 * The Eloquent charge model.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCharge';

	/**
	 * The Eloquent charge refund model.
	 *
	 * @var string
	 */
	protected static $chargeRefundModel = 'Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund';

	/**
	 * The Eloquent invoice model.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoice';

	/**
	 * The Eloquent invoice item model.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem';

	/**
	 * The Eloquent subscription model.
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
		return $this->hasMany(static::$cardModel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function card($card = null)
	{
		return new CardGateway($this, $card);
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
		return $this->getStripeClient()->customers()->update([
			'id'   => $this->getStripeId(),
			'card' => $token,
		]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function charges()
	{
		return $this->hasMany(static::$chargeModel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function charge($charge = null)
	{
		return new ChargeGateway($this, $charge);
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

		forward_static_call_array([static::$chargeRefundModel, 'setChargeModel'], [$model]);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setChargeRefundModel($model)
	{
		static::$chargeRefundModel = $model;

		forward_static_call_array([static::$chargeModel, 'setRefundModel'], [$model]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoices()
	{
		return $this->hasMany(static::$invoiceModel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoice($invoice = null)
	{
		return new InvoiceGateway($this, $invoice);
	}

	/**
	 * {@inheritDoc}
	 */
	public function invoiceItems()
	{
		return $this->hasMany(static::$invoiceItemModel);
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

		forward_static_call_array([static::$chargeModel, 'setInvoiceModel'], [$model]);
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

		forward_static_call_array([static::$invoiceModel, 'setInvoiceItemModel'], [$model]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function subscriptions()
	{
		return $this->hasMany(static::$subscriptionModel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function subscription($subscription = null)
	{
		return new SubscriptionGateway($this, $subscription);
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
	public function syncWithStripe()
	{
		if ( ! $this->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		$this->card()->syncWithStripe();

		$this->charge()->syncWithStripe();

		$this->invoice()->syncWithStripe();

		$this->subscription()->syncWithStripe();
	}

	/**
	 * {@inheritDoc}
	 */
	public static function attachStripeAccount(array $data, Closure $callback, $sync = true)
	{
		// Do we have an entity?
		if ($entity = $callback($data))
		{
			// Store the Stripe Customer Id
			$entity->stripe_id = $data['id'];
			$entity->save();

			// Should we syncronize the data with Stripe?
			if ($sync)
			{
				// Syncronize the data
				$entity->syncWithStripe();
			}

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getStripeClient()
	{
		return static::$stripeClient ?: App::make('stripe');
	}

}
