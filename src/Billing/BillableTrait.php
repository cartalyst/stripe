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
	 * The Stripe instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $stripeClient;

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
	 * The Eloquent subscription model.
	 *
	 * @var string
	 */
	protected static $subscriptionModel = 'Cartalyst\Stripe\Billing\Models\IlluminateSubscription';

	/**
	 * The Eloquent invoice model.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoice';

	/**
	 * {@inheritDoc}
	 */
	public function isBillable()
	{
		return $this->stripe_id;
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
	public static function setCardModel($model)
	{
		static::$cardModel = $model;
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
	public static function setChargeModel($model)
	{
		static::$chargeModel = $model;
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
	public static function setSubscriptionModel($model)
	{
		static::$subscriptionModel = $model;
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
	public function invoices()
	{
		return $this->hasMany(static::$invoiceModel);
	}

	/**
	 * {@inheritDoc}
	 */
	public static function setInvoiceModel($model)
	{
		static::$invoiceModel = $model;
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
	public function hasActiveCard()
	{
		return (bool) $this->cards->count();
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
	public function getStripeId()
	{
		return $this->stripe_id;
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
	 * Returns the Stripe instance.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	public function getStripeClient()
	{
		return $this->stripeClient ?: App::make('stripe');
	}

	/**
	 * Returns the Stripe gateway instance.
	 *
	 * @return \Cartalyst\Stripe\Billing\StripeGateway
	 */
	protected function gateway()
	{
		return $this->gateway ?: new StripeGateway($this);
	}

}
