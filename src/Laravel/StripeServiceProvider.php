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

use Cartalyst\Stripe\Api\Stripe;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Stripe\StripeMigratorCommand;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerStripe();

		$this->setStripeClientOnBillableEntity();

		$this->app['command.stripe.migrator'] = $this->app->share(function($app)
		{
			return new StripeMigratorCommand;
		});

		$this->commands('command.stripe.migrator');
	}

	/**
	 * Register Stripe.
	 *
	 * @return void
	 */
	protected function registerStripe()
	{
		$this->app['stripe'] = $this->app->share(function($app)
		{
			$stripeKey = $app['config']->get('services.stripe.secret');

			$version = $app['config']->get('services.stripe.version');

			$manifestPath = $app['config']->get('services.stripe.manifestPath');

			return new Stripe($stripeKey, $version, $manifestPath);
		});
	}

	/**
	 * Sets the Stripe API client on the billable entity.
	 *
	 * @return void
	 */
	protected function setStripeClientOnBillableEntity()
	{
		$model = $this->app['config']->get('services.stripe.model');

		$model::setStripeClient($this->app['stripe']);
	}

}
