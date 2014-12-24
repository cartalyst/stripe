<?php namespace Cartalyst\Stripe\Laravel\Console;
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

use Illuminate\Console\Command;
use Symfony\Component\Console\Input;

class SyncCommand extends Command {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'stripe:sync';

	/**
	 * {@inheritDoc}
	 */
	protected $description = 'A command to synchronize your Stripe account.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Get the selected synchronization models
		$models = $this->getSelectedModels();

		// Get the selected synchronization entities
		$entities = $this->getSelectedEntities();

		// Loop through all the selected types
		foreach ($this->getSelectedTypes() as $type)
		{
			// Instantiate the class
			$sync = $this->getSyncClass($type);

			// Prepare the synchronization class
			$sync->setModels($models)->setEntities($entities);

			// Execute the synchronization process
			$sync->execute();
		}
	}

	/**
	 * Returns all the registered synchronization types.
	 *
	 * @return array
	 */
	protected function getRegisteredTypes()
	{
		return array_keys(array_where($this->laravel->getBindings(), function($key, $value)
		{
			return str_contains($key, 'stripe.sync.');
		}));
	}

	/**
	 * Returns the given type class object.
	 *
	 * @param  string  $type
	 * @return \Cartalyst\Stripe\Console\Sync\AbstractSync
	 * @throws \Exception
	 */
	protected function getSyncClass($type)
	{
		$class = "stripe.sync.{$type}";

		if (in_array($class, $this->getRegisteredTypes()))
		{
			return $this->laravel[$class];
		}

		throw new \Exception(
			"The synchronization type [{$class}] is not registered!"
		);
	}

	/**
	 * Returns the selected types.
	 *
	 * @return array
	 */
	protected function getSelectedTypes()
	{
		$types = $this->prepareOption(
			$this->option('type')
		);

		return in_array('all', $types) ? [ 'all' ] : $types;
	}

	/**
	 * Returns the selected models.
	 *
	 * @return array
	 */
	protected function getSelectedModels()
	{
		return $this->prepareOption(
			$this->option('model')
		);
	}

	/**
	 * Returns the selected entities.
	 *
	 * @return array
	 */
	protected function getSelectedEntities()
	{
		return $this->prepareOption(
			$this->option('entity')
		);
	}

	/**
	 * Returns the given option formatted as an array.
	 *
	 * @param  string  $option
	 * @return array
	 */
	protected function prepareOption($option)
	{
		return array_unique(
			array_filter(
				array_map('trim', explode(',', $option))
			)
		);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getOptions()
	{
		return [

			[ 'type', null, Input\InputOption::VALUE_OPTIONAL, '...' ],

			[ 'model', null, Input\InputOption::VALUE_OPTIONAL, '...' ],

			[ 'entity', null, Input\InputOption::VALUE_OPTIONAL, '...' ],

		];
	}

}
