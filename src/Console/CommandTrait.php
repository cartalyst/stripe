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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait CommandTrait {

	/**
	 * The cached helpers instances.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Execute the command.
	 *
	 * @param  \Symfony\Component\Console\Input\InputInterface  $input
	 * @param  \Symfony\Component\Console\Output\OutputInterface  $output
	 * @return void
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;

		$this->output = $output;

		return $this->fire();
	}

	/**
	 * Returns an argument from the input.
	 *
	 * @param  string  $key
	 * @param  string  $default
	 * @return string
	 */
	public function argument($key, $default = null)
	{
		return $this->input->getArgument($key) ?: $default;
	}

	/**
	 * Returns an option from the input.
	 *
	 * @param  string  $key
	 * @param  string  $default
	 * @return string
	 */
	public function option($key, $default = null)
	{
		return $this->input->getOption($key) ?: $default;
	}

	/**
	 * Ask the user the given question.
	 *
	 * @param  string  $question
	 * @return string
	 */
	public function ask($question)
	{
		$dialog = $this->findHelper('dialog');

		return $dialog->ask($this->output, "<comment>{$question}</comment> ");
	}

	/**
	 * Ask the user the given secret question.
	 *
	 * @param  string  $question
	 * @return string
	 */
	public function secret($question)
	{
		$dialog = $this->findHelper('dialog');

		return $dialog->askHiddenResponse($this->output, "<comment>{$question}</comment> ", false);
	}

	/**
	 * Confirm a question with the user.
	 *
	 * @param  string  $question
	 * @param  bool  $default
	 * @return bool
	 */
	public function confirm($question, $default = true)
	{
		$dialog = $this->findHelper('dialog');

		return $dialog->askConfirmation($this->output, "<question>{$question}</question> ", $default);
	}

	/**
	 * Write a string as information output.
	 *
	 * @param  string  $string
	 * @return void
	 */
	public function info($string)
	{
		$this->output->writeln("<info>{$string}</info>");
	}

	/**
	 * Write a string as comment output.
	 *
	 * @param  string  $string
	 * @return void
	 */
	public function comment($string)
	{
		$this->output->writeln("<comment>{$string}</comment>");
	}

	/**
	 * Write a string as question output.
	 *
	 * @param  string  $string
	 * @return void
	 */
	public function question($string)
	{
		$this->output->writeln("<question>{$string}</question>");
	}

	/**
	 * Write a string as error output.
	 *
	 * @param  string  $string
	 * @return void
	 */
	public function error($string)
	{
		$this->output->writeln("<error>{$string}</error>");
	}

	/**
	 * Returns the given helper instance.
	 *
	 * @param  string  $helper
	 * @return mixed
	 */
	protected function findHelper($helper)
	{
		if ( ! array_key_exists($helper, $this->helpers))
		{
			$this->helpers[$helper] = $this->getHelperSet()->get($helper);
		}

		return $this->helpers[$helper];
	}

}
