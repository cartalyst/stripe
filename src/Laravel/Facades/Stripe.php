<?php namespace Cartalyst\Stripe\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Stripe extends Facade {

	/**
	 * {@inheritDoc}
	 */
	protected static function getFacadeAccessor()
	{
		return 'stripe';
	}

}
