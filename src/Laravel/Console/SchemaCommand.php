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
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
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
			'version' => $this->argument('version'),
			'--path'  => $this->laravel['path'].'/database/migrations/',
		]);

		$command = new BaseSchemaCommand(__DIR__.'/stubs');
		$command->setHelperSet($this->getDefaultHelperSet());
		$command->run($input, $this->output);

		$this->call('dump-autoload');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function getArguments()
	{
		return [

			[ 'version', InputArgument::OPTIONAL, 'The version you want to upgrade from.' ],

		];
	}

    /**
     * Returns the default helper set with the helpers that should be available.
     *
     * @return \Symfony\Component\Console\Helper\HelperSet
     */
	protected function getDefaultHelperSet()
	{
		return new HelperSet([
			new DialogHelper, new FormatterHelper, new ProgressHelper, new TableHelper,
		]);
	}

}
