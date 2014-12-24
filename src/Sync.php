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

use Cartalyst\Stripe\Api\Stripe;

class Sync {

	/**
	 * The Stripe API instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $stripe;

	/**
	 *
	 *
	 * @var array
	 */
	protected $models = [];

	protected $entity;

	/**
	 * The registered synchronization types.
	 *
	 * @var array
	 */
	protected $types;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Api\Stripe  $stripe
	 * @param  array  $types
	 * @return void
	 */
	public function __construct(Stripe $stripe, array $types  =[])
	{
		$this->stripe = $stripe;

		$this->types = $types;
	}

	/**
	 * Make a new Sync instance.
	 *
	 * @param  \Cartalyst\Stripe\Api\Stripe  $stripe
	 * @param  array  $types
	 * @return \Cartalyst\Stripe\Sync
	 */
	public static function make(Stripe $stripe, array $types = [])
	{
		return new static($stripe, $types);
	}

	/**
	 * Returns all the registered models.
	 *
	 * @return array
	 */
	public function getModels()
	{
		return $this->models;
	}

	/**
	 * Sets
	 *
	 * @param  array  $models
	 * @return $this
	 */
	public function setModels(array $models)
	{
		$this->models = $models;

		return $this;
	}

	public function getTypes()
	{
		return $this->types;
	}

	public function registerType(TypeInterface $type)
	{
		$this->types[$type->getId()] = $type;

		return $this;
	}

	public function entity(BillableInterface $entity)
	{
		$this->entity = $entity;

		return $this;
	}

	public function all()
	{
		if ( ! $this->entity)
		{
			# loop through all the models and sync them
			foreach ($this->models as $model)
			{

			}
		}
		else
		{
			#
		}


		# if we have an entity, we sync everything for that entity
		# otherwise, we fetch all models and all entities for each
		# model!
	}

	public function __call($method, array $arguments = [])
	{

	}

}
