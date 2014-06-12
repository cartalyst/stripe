<?php namespace Cartalyst\Stripe;

use Config;
use Cartalyst\Stripe\Laravel\Facades\Stripe as StripeFacade;
use Illuminate\Support\Facades\App;

trait BillableTrait {

	/**
	 * Returns the Stripe client.
	 *
	 * @return \Cartalyst\Stripe\Client
	 */
	public function getStripeClient()
	{
		return App::make('stripe.client');
	}

	###
	public function customer()
	{
		return StripeFacade::customers();
	}
	###


	public function card()
	{
		return StripeFacade::cards();
	}

	public function cards()
	{
		return $this->hasMany('Cartalyst\Stripe\IlluminateCard');
	}


	public function charge()
	{
		return StripeFacade::charges();
	}

	public function charges()
	{
		return $this->hasMany('Cartalyst\Stripe\IlluminateCharge');
	}


	public function subscription()
	{
		return StripeFacade::subscriptions();
	}

	public function subscriptions()
	{
		return $this->hasMany('Cartalyst\Stripe\IlluminateSubscriptions');
	}


}
