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

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Cartalyst\Stripe\Console\SchemaCommand as BaseSchemaCommand;

class SchemaCommand extends \Illuminate\Console\Command {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'stripe:schema';

	/**
	 * {@inheritDoc}
	 */
	protected $description = 'Creates the appropriate migration files for the Stripe database tables.';

	/**
	 * {@inheritDoc}
	 */
	public function fire()
	{
		$input = new ArrayInput([
			'entity'  => $this->argument('entity'),
			'version' => $this->argument('version'),
			'--path'  => $this->laravel['path'].'/database/migrations/',
		]);

		$stubsPath = __DIR__.'/stubs';

		(new BaseSchemaCommand($stubsPath))->run($input, $this->output);

		$this->call('dump-autoload');
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

}
