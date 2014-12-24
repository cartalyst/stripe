<?php namespace Cartalyst\Stripe\Sync;

interface TypeInterface {

	/**
	 * Returns the type identification.
	 *
	 * @return mixed
	 */
	public function getId();

	/**
	 * Executes the synchronization command.
	 *
	 * @return mixed
	 */
	public function execute();

}
