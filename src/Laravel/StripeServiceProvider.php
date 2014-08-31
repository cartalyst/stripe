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
use Cartalyst\Stripe\StripeTableCommand;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerStripe();

		$this->registerTableCommand();

		$this->setStripeClientOnBillableEntity();
	}

	/**
     * {@inheritDoc}
     */
    public function provides()
    {
        return ['stripe'];
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
			$apiKey = $app['config']->get('services.stripe.secret');

			$version = $app['config']->get('services.stripe.version');

			$manifestPath = $app['config']->get('services.stripe.manifestPath');

			return new Stripe($apiKey, $version, $manifestPath);
		});

		$this->app->alias('stripe', 'Cartalyst\Stripe\Api\Stripe');
	}

	/**
	 * Registers the Stripe table command.
	 *
	 * @return void
	 */
	protected function registerTableCommand()
	{
		$this->app['command.stripe.table'] = $this->app->share(function($app)
		{
			return new StripeTableCommand;
		});

		$this->commands('command.stripe.table');
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
