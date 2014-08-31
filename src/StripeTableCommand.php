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

		if ( ! version_compare($this->currentVersion, $fromVersion, '>='))
		{
			return $this->error(
				"The version you want to upgrade from is higher than the current available version."
			);
		}

		$this->generateMigrations($fromVersion);

		$this->info('Migrations successfully created!');

		$this->call('dump-autoload');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getArguments()
	{
		return [

			[ 'table', InputArgument::REQUIRED, 'The name of your billable table.' ],

			[ 'from_version', InputArgument::OPTIONAL, 'The version you want to upgrade from.' ],

		];
	}

	/**
	 * Returns the full migration path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	protected function getPath($path)
	{
		return $this->laravel['path']."/database/migrations/{$path}.php";
	}

	/**
	 * Generates all the migrations from the stubs.
	 *
	 * @param  string  $fromVersion
	 * @return void
	 */
	protected function generateMigrations($fromVersion)
	{
		foreach ($this->getMigrationsFromVersion($fromVersion) as $version => $path)
		{
			$this->generateMigration($path);
		}
	}

	/**
	 * Generate a single migration from the given stub path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	protected function generateMigration($path)
	{
		$this->laravel['files']->put(
			$this->getPath($path),
			$this->getMigrationStubContents($path)
		);
	}

	/**
	 * Returns the contents of the migration stub.
	 *
	 * @param  string  $path
	 * @return string
	 */
	protected function getMigrationStubContents($path)
	{
		$contents = file_get_contents(__DIR__."/stubs/{$path}.stub");

		$tableName = $this->argument('table');

		$search = [ 'billable_table', 'billable_column' ];

		$replace = [ $tableName, str_singular($tableName) ];

		return str_replace($search, $replace, $contents);
	}

	/**
	 * Returns all the migrations from the given version.
	 *
	 * @param  string  $fromVersion
	 * @return array
	 */
	protected function getMigrationsFromVersion($fromVersion)
	{
		return array_where($this->getMigrations(), function($key, $value) use ($fromVersion)
		{
			return version_compare($fromVersion, $key) === 1 ? false : true;
		});
	}

	/**
	 * Returns all the package migrations.
	 *
	 * @return array
	 */
	protected function getMigrations()
	{
		$migrations = [];

		foreach ((new Finder)->files()->in(__DIR__.'/stubs') as $file)
		{
			preg_match('/([0-9]\_[0-9]\_)\w/', $file->getFileName(), $matches);

			$version = str_replace('_', '.', $matches[0]);

			$name = str_replace('.stub', null, $file->getRelativePathname());

			$migrations[$version] = $name;
		}

		return $migrations;
	}

}
