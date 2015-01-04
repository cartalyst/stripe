<?php namespace Cartalyst\Stripe\Laravel;
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
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Stripe\Stripe;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerStripe();
	}

	/**
	 * {@inheritDoc}
	 */
	public function provides()
	{
		return [
			'stripe',
		];
	}

	/**
	 * Register the Stripe API class.
	 *
	 * @return void
	 */
	protected function registerStripe()
	{
		$this->app->bindShared('stripe', function($app)
		{
			$config = $app['config']->get('services.stripe');

			return new Stripe(
				array_get($config, 'secret'), array_get($config, 'version')
			);
		});

		$this->app->alias('stripe', 'Cartalyst\Stripe\Stripe');
	}

}
