<?php namespace Cartalyst\Stripe\Console;
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

class TableCommand extends Command {

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

		if ( ! version_compare($this->currentVersion, $fromVersion, '>'))
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
	 * @param  string  $version
	 * @return void
	 */
	protected function generateMigrations($version)
	{
		foreach ($this->getMigrationsFromVersion($version) as $path)
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
		$tables = array_unique(
			array_filter(
				array_map('trim', explode(',', $this->argument('table')))
			)
		);

		$search = [ '{{billable_tables_up}}', '{{billable_tables_down}}' ];

		$replace = [
			$this->prepareBillableStub($tables, 'up'),
			$this->prepareBillableStub($tables, 'down')
		];

		return str_replace($search, $replace, $this->getStubContents($path));
	}

	/**
	 * Returns all the migrations from the given version.
	 *
	 * @param  string  $version
	 * @return array
	 */
	protected function getMigrationsFromVersion($version)
	{
		return array_where($this->getMigrations(), function($key, $value) use ($version)
		{
			return version_compare($version, $key) === 1 ? false : true;
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

		foreach ((new Finder)->files()->in(__DIR__.'/../stubs') as $file)
		{
			preg_match('/([0-9]\_[0-9]\_)\w/', $file->getFileName(), $matches);

			if (count($matches))
			{
				$version = str_replace('_', '.', $matches[0]);

				$name = str_replace('.stub', null, $file->getRelativePathname());

				$migrations[$version] = $name;
			}
		}

		return $migrations;
	}

	/**
	 * Prepares the billable tables.
	 *
	 * @param  array  $tables
	 * @param  string  $type
	 * @return string
	 */
	protected function prepareBillableStub(array $tables, $type)
	{
		$contents = implode("\n\t\t", preg_split("/((\r?\n)|(\r\n?))/",
			$this->getStubContents("billable_table_{$type}")
		));

		$content = array_map(function($table) use ($contents)
		{
			return str_replace('billable_table', $table, $contents);
		}, $tables);

		return preg_replace(
			"/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n\n", rtrim(implode("\n\t\t", $content), "\n\t\t")
		);
	}

	/**
	 * Returns the given stub file contents.
	 *
	 * @param  string  $stub
	 * @return string
	 */
	protected function getStubContents($stub)
	{
		return file_get_contents(__DIR__."/../stubs/{$stub}.stub");
	}

}
