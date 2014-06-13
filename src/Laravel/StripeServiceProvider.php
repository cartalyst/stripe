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
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Stripe\Stripe;
use Cartalyst\Stripe\Http\HttpClient;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerStripe();
	}

	/**
	 * Register the Stripe.
	 *
	 * @return void
	 */
	protected function registerStripe()
	{
		$this->app['stripe.client'] = $this->app->share(function($app)
		{
			$stripeKey = $app['config']->get('services.stripe.secret');

			$options = [
				'defaults' => [
					'auth' => [
						$stripeKey, null,
					],
				],
			];

			return new HttpClient($options);
		});

		$this->app['stripe'] = $this->app->share(function($app)
		{
			return new Stripe($app['stripe.client']);
		});
	}

}
