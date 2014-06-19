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

use Illuminate\Support\Facades\App;

trait BillableTrait {

	/**
	 * The Stripe gateway instance.
	 *
	 * @var \Cartalyst\Stripe\StripeGateway
	 */
	protected $gateway;

	/**
	 * The Stripe instance.
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $stripeClient;

	/**
	 * {@inheritDoc}
	 */
	public function cards()
	{
		return $this->hasMany('Cartalyst\Stripe\Models\IlluminateCard');
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
	public function charges()
	{
		return $this->hasMany('Cartalyst\Stripe\Models\IlluminateCharge');
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
	public function subscriptions()
	{
		return $this->hasMany('Cartalyst\Stripe\Models\IlluminateSubscription');
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
		])->toArray();
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
		$this->card()->syncWithStripe();

		$this->charge()->syncWithStripe();

		$this->subscription()->syncWithStripe();
	}

	/**
	 * Returns the Stripe instance.
	 *
	 * @return \Cartalyst\Stripe\Stripe
	 */
	public function getStripeClient()
	{
		return $this->stripeClient ?: App::make('stripe');
	}

	/**
	 * Returns the Stripe gateway instance.
	 *
	 * @return \Cartalyst\Stripe\StripeGateway
	 */
	protected function gateway()
	{
		return $this->gateway ?: new StripeGateway($this);
	}

}
