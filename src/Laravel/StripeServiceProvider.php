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
use Cartalyst\Stripe\Sync;
use InvalidArgumentException;
use Cartalyst\Stripe\Api\Stripe;
use Cartalyst\Stripe\Laravel\Console;
use Cartalyst\Stripe\BillableInterface;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->registerStripe();

		$this->registerStripeSync();

		// $this->registerSyncCommand();

		$this->registerSchemaCommand();

		// $this->registerSyncCommandTypes();

		$this->setStripeClientOnBillableEntity();
	}

	/**
	 * {@inheritDoc}
	 */
	public function provides()
	{
		return [
			'stripe',
			'stripe.sync',
			'stripe.sync.cards',
			'stripe.sync.plans',
			'stripe.sync.charges',
			'stripe.sync.coupons',
			'stripe.sync.invoices',
			'stripe.sync.customers',
			'stripe.sync.recipients',
			'stripe.sync.subscriptions',
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
	 * Register the Stripe Sync.
	 *
	 * @return void
	 */
	protected function registerStripeSync()
	{
		$this->app->bindShared('stripe.sync', function($app)
		{
			# need to pass in the types as well..

			return new Sync($app['stripe']);
		});

		$this->app->alias('stripe.sync', 'Cartalyst\Stripe\Sync');
	}

	/**
	 * Register the Stripe Sync command.
	 *
	 * @return void
	 */
	protected function registerSyncCommand()
	{
		$this->app->bindShared('command.stripe.sync', function($app)
		{
			return new Console\SyncCommand;
		});

		$this->commands('command.stripe.sync');
	}

	/**
	 * Register the Stripe Sync command types.
	 *
	 * @return void
	 */
	protected function registerSyncCommandTypes()
	{
		$types = [
			'all', # not sure..
			'cards',
			'plans',
			'charges',
			'coupons',
			'invoices',
			'customers',
			'recipients',
			'subscriptions',
		];

		foreach ($types as $type)
		{
			$this->app->bindShared('stripe.sync.'.$type, function($app) use ($type)
			{
				$class = 'Cartalyst\\Stripe\\Sync\\'.ucfirst($type).'Sync';

				return new $class($app);
			});
		}
	}

	/**
	 * Registers the Stripe schema command.
	 *
	 * @return void
	 */
	protected function registerSchemaCommand()
	{
		$this->app->bindShared('command.stripe.schema', function($app)
		{
			return new Console\SchemaCommand;
		});

		$this->commands('command.stripe.schema');
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
