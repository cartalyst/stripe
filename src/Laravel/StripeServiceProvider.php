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

use Exception;
use Cartalyst\Stripe\Console;
use InvalidArgumentException;
use Cartalyst\Stripe\Api\Stripe;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Stripe\BillableInterface;

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
				array_get($config, 'secret'),
				array_get($config, 'version'),
				array_get($config, 'manifest_path')
			);
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
		$this->app->bindShared('command.stripe.table', function($app)
		{
			return new Console\TableCommand;
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
		$entities = array_filter(array_unique(
			(array) $this->app['config']->get('services.stripe.model')
		));

		foreach ($entities as $entity)
		{
			if ( ! class_exists($entity))
			{
				throw new Exception(
					"The '{$entity}' model was not found or doesn't exist!"
				);
			}

			if ( ! $this->app[$entity] instanceof BillableInterface)
			{
				throw new InvalidArgumentException(
					"The '{$entity}' model needs to implement the 'Cartalyst\Stripe\BillableInterface' interface."
				);
			}

			$entity::setStripeClient($this->app['stripe']);
		}
	}

}
