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

class SchemaCommand extends \Symfony\Component\Console\Command\Command {

	use CommandTrait;

	/**
	 * The selected billable table names.
	 *
	 * @var array
	 */
	protected $billableEntities = [];

	/**
	 * The selected storage path for the generated schema files.
	 *
	 * @var string
	 */
	protected $storagePath = [];

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
	public function __construct($stubsPath = __DIR__.'/../Native/stubs')
	{
		parent::__construct();

		$this->finder = new Finder;

		$this->stubsPath = $stubsPath;

		$this->filesystem = new Filesystem;
	}

	/**
	 * {@inheritDoc}
	 */
	protected function configure()
	{
		$this
			->setName('schema')
			->setDescription('Creates the appropriate schema files for the Stripe database tables.')
			->addArgument('version', InputArgument::OPTIONAL, 'The version you want to upgrade from.')
			->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path to where the schema file will be stored.')
		;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fire()
	{
		// Get the selected version
		$version = $this->argument('version');

		// Ask the user to type in the billable table names
		$this->askForEntity();

		// Ask the user to type the storage path
		$this->askForStoragePath();

		// Compare the selected version with the current available version
		if ( ! version_compare(Stripe::getVersion(), $version, '>'))
		{
			throw new \InvalidArgumentException(
				"The version you want to upgrade from is higher than the current available version."
			);
		}

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
	 * Returns the storage path.
	 *
	 * @return string
	 */
	protected function getStoragePath()
	{
		return $this->storagePath;
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
			$this->getStoragePath().'/'.$file->getFileName(),
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
		$search = [ '{{billable_tables_up}}', '{{billable_tables_down}}' ];

		$replace = [
			$this->prepareBillableStub('up'), $this->prepareBillableStub('down'),
		];

		return str_replace($search, $replace, file_get_contents($file->getPathName()));
	}

	/**
	 * Prepares the billable tables.
	 *
	 * @param  string  $type
	 * @return string
	 */
	protected function prepareBillableStub($type)
	{
		$fileContent = file_get_contents(
			$this->getStubsPath()."/billable_table_{$type}.stub"
		);

		$callback = function ($table) use ($fileContent)
		{
			return str_replace('billable_table', $table, $fileContent);
		};

		$content = array_map($callback, $this->billableEntities);

		return preg_replace(
			"/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n\n", rtrim(implode("\n", $content), "\n\t\t")
		);
	}

	/**
	 * Asks the users to type the billable table names.
	 *
	 * @return void
	 */
	protected function askForEntity()
	{
		if ( ! $entity = $this->ask('Please type the billable table name'))
		{
			return $this->askForEntity();
		}

		if ( ! in_array($entity, $this->billableEntities))
		{
			$this->billableEntities[] = $entity;
		}

		if ($this->confirm('Would you like to add another billable table? (y/N)', false))
		{
			return $this->askForEntity();
		}
	}

	/**
	 * Asks the users to type the storage path.
	 *
	 * @return void
	 */
	protected function askForStoragePath()
	{
		if ( ! $storagePath = $this->option('path', null))
		{
			$storagePath = $this->ask('Type the full storage path');
		}

		$this->storagePath = $storagePath;
	}

}
