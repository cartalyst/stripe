<?php namespace Cartalyst\Stripe\Sync;
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

abstract class AbstractSync {

	/**
	 * The Stripe API instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $stripe;

	/**
	 * Holds all the selected models.
	 *
	 * @var array
	 */
	protected $models = [];

	/**
	 * Holds all the selected entities.
	 *
	 * @var array
	 */
	protected $entities = [];

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Api\Stripe  $stripe
	 * @return void
	 */
	public function __construct(Stripe $stripe)
	{
		$this->stripe = $stripe;
	}

	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the selected models.
	 *
	 * @param  array  $models
	 * @return $this
	 */
	public function setModels(array $models)
	{
		$this->models = $models;

		return $this;
	}

	/**
	 * Sets the selected entities.
	 *
	 * @param  array  $entities
	 * @return $this
	 */
	public function setEntities(array $entities)
	{
		$this->entities = $entities;

		return $this;
	}

}
