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
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Input\InputArgument;

class StripeTableCommand extends Command {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'stripe:table';

	/**
	 * {@inheritDoc}
	 */
	protected $description = 'Creates the appropriate migration files for the Stripe database tables.';

	/**
	 * The current package version.
	 *
	 * @var string
	 */
	protected $currentVersion = '1.0.0';

	/**
	 * {@inheritDoc}
	 */
	public function fire()
	{
		$fromVersion = $this->argument('from_version');

		$toVersion = $this->argument('to_version');

		//
		if ( ! version_compare($this->currentVersion, $fromVersion, '>='))
		{
			return $this->error(
				"The version you want to upgrade from is higher than the current available version."
			);
		}

		//
		if ($fromVersion && $toVersion && version_compare($toVersion, $fromVersion, '<'))
		{
			return $this->error(
				"The version you want to upgrade to is lower than the version you want to upgrade from."
			);
		}

		// Get all the migration files
		$migrations = $this->getAllMigrationStubs($fromVersion, $toVersion);

		if ($fromVersion && $toVersion)
		{
			# generate from the given version to the given version
		}
		elseif ($fromVersion && ! $toVersion)
		{
			# generate from the given version
		}
		else
		{
			# generate all migrations
		}

		// $fullPath = $this->createBaseMigration();

		// file_put_contents($fullPath, $this->getMigrationStubContents());

		// $this->info('Migration successfully created!');

		// $this->call('dump-autoload');
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

			[ 'table', InputArgument::REQUIRED, 'The name of your billable table.' ],

			[ 'from_version', InputArgument::OPTIONAL, '' ],

			[ 'to_version', InputArgument::OPTIONAL, '' ],

		];
	}

	protected function getAllMigrationStubs($fromVersion = null, $toVersion = null)
	{
		$migrations = [];

		foreach ((new Finder)->files()->in(__DIR__.'/stubs') as $file)
		{
			preg_match('/([0-9]\_[0-9]\_)\w/', $file->getFileName(), $matches);

			$version = str_replace('_', '.', $matches[0]);

			$migrations[$version] = $file->getRealPath();
		}

		if ($fromVersion)
		{
			$migrations = array_where($migrations, function($key, $value) use ($fromVersion, $toVersion)
			{
				return version_compare($fromVersion, $key) === 1 ? false : true;
			});
		}

		return $migrations;
	}

}
