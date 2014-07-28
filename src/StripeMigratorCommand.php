<?php namespace Cartalyst\Stripe;
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
use Symfony\Component\Console\Input\InputArgument;

class StripeMigratorCommand extends Command {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'stripe:migrator';

	/**
	 * {@inheritDoc}
	 */
	protected $description = 'Create a migration for the Stripe database tables.';

	/**
	 * {@inheritDoc}
	 */
	public function fire()
	{
		$fullPath = $this->createBaseMigration();

		file_put_contents($fullPath, $this->getMigrationStubContents());

		$this->info('Migration successfully created!');

		$this->call('dump-autoload');
	}

	/**
	 * Create a base migration file for the reminders.
	 *
	 * @return string
	 */
	protected function createBaseMigration()
	{
		$name = 'cartalyst_stripe_create_tables';

		$path = $this->laravel['path'].'/database/migrations';

		return $this->laravel['migration.creator']->create($name, $path);
	}

	/**
	 * Returns the contents of the migration stub.
	 *
	 * @return string
	 */
	protected function getMigrationStubContents()
	{
		$contents = file_get_contents(__DIR__.'/stubs/migration.stub');

		$tableName = $this->argument('table');

		$search = [ 'billable_table', 'billable_column' ];

		$replace = [ $tableName, str_singular($tableName) ];

		return str_replace($search, $replace, $contents);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getArguments()
	{
		return [

			['table', InputArgument::REQUIRED, 'The name of your billable table.'],

		];
	}

}
