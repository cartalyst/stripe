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

use Cartalyst\Stripe\Api\Stripe;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SchemaCommand extends Command {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'schema';

	/**
	 * {@inheritDoc}
	 */
	protected $description = 'Creates the appropriate schema files for the Stripe database tables.';

	/**
	 * The Schema stubs path.
	 *
	 * @var string
	 */
	protected $stubsPath;

	/**
	 * The Symfony Finder instance.
	 *
	 * @var \Symfony\Component\Finder\Finder
	 */
	protected $finder;

	/**
	 * The Symfony Filesystem instance.
	 *
	 * @var \Symfony\Component\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * Constructor.
	 *
	 * @param  string  $stubsPath
	 * @return void
	 */
	public function __construct($stubsPath = __DIR__.'/stubs')
	{
		parent::__construct();

		$this->finder = new Finder;

		$this->stubsPath = $stubsPath;

		$this->filesystem = new Filesystem;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fire()
	{
		// Get the selected version
		$version = $this->argument('version');

		// Compare the selected version with the current available version
		if ( ! version_compare(Stripe::getVersion(), $version, '>'))
		{
			throw new \InvalidArgumentException(
				"The version you want to upgrade from is higher than the current available version."
			);
		}

		if ( ! $this->option('path')) throw new \RuntimeException('The "--path" is required.');

		$this->generateSchemaFiles($version);

		$this->info('Schema files successfully created!');
	}

	/**
	 * Returns all the schema files.
	 *
	 * @return array
	 */
	protected function getSchemaFiles()
	{
		return iterator_to_array(
			$this->finder->files()->in($this->getStubsPath())->name('/([0-9]\_[0-9]\_)\w/')
		);
	}

	/**
	 * Generates all the schema files from the stubs.
	 *
	 * @param  string  $version
	 * @return void
	 */
	protected function generateSchemaFiles($version)
	{
		foreach ($this->getSchemaFiles() as $file)
		{
			preg_match('/([0-9]\_[0-9]\_)\w/', $file->getFileName(), $matches);

			$fileVersion = str_replace('_', '.', $matches[0]);

			if (version_compare($version, $fileVersion) !== 1)
			{
				$this->storeSchemaFile($file);
			}
		}
	}

	/**
	 * Returns the schema stubs location path.
	 *
	 * @return string
	 */
	protected function getStubsPath()
	{
		return $this->stubsPath;
	}

	/**
	 * Store the schema file on the given path.
	 *
	 * @param  \Symfony\Component\Finder\SplFileInfo  $file
	 * @return void
	 */
	protected function storeSchemaFile(SplFileInfo $file)
	{
		$this->filesystem->dumpFile(
			$this->option('path').'/'.$file->getFileName(),
			$this->getSchemaStubContents($file)
		);
	}

	/**
	 * Returns the contents of the migration stub.
	 *
	 * @param  \Symfony\Component\Finder\SplFileInfo  $file
	 * @return string
	 */
	protected function getSchemaStubContents(SplFileInfo $file)
	{
		$tables = array_unique(array_filter(
			array_map('trim', explode(',', $this->argument('entity')))
		));

		$search = [ '{{billable_tables_up}}', '{{billable_tables_down}}' ];

		$replace = [
			$this->prepareBillableStub($tables, 'up'),
			$this->prepareBillableStub($tables, 'down')
		];

		return str_replace($search, $replace, file_get_contents($file->getPathName()));
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
			file_get_contents(
				$this->getStubsPath()."/billable_table_{$type}.stub"
			)
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
	 * {@inheritDoc}
	 */
	protected function getArguments()
	{
		return [

			[ 'entity', InputArgument::REQUIRED, 'The name of your billable table.' ],

			[ 'version', InputArgument::OPTIONAL, 'The version you want to upgrade from.' ],

		];
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getOptions()
	{
		return [

			[ 'path', null, InputOption::VALUE_REQUIRED, 'The path to where the schema file will be stored.' ],

		 ];
	}

}
