<?php namespace Cartalyst\Stripe\Laravel;

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
