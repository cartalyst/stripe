<?php namespace Cartalyst\Stripe\Api;
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

class Customers extends AbstractApi {

	/**
	 * Returns all the Stripe customers.
	 *
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\Customers
	 */
	public function all(array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->_get('customers', $arguments);
		return $instance;
	}

	public function create(array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->_post('customers', $arguments);
		return $instance;
	}

	/**
	 * Returns a Stripe customer.
	 *
	 * @param  string  $id
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\Customers
	 */
	public function find($id, array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->_get("customers/{$id}", $arguments);
		return $instance;
	}

	/**
	 * Updates the Stripe customer.
	 *
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\Customers
	 */
	public function update(array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->_post("customers/{$this->id}", $arguments);
		return $instance;
	}

	/**
	 * Deletes the Stripe customer.
	 *
	 * @return bool
	 */
	public function delete()
	{
		$this->_delete("customers/{$this->id}");

		return true;
	}

}
