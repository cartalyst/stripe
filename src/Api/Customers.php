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
		return $this->handleRequest('GET', 'customers', $arguments);
	}

	/**
	 * Creates a new Stripe customer.
	 *
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\Customers
	 */
	public function create(array $arguments = [])
	{
		return $this->handleRequest('POST', 'customers', $arguments);
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
		return $this->handleRequest('GET', "customers/{$id}", $arguments);
	}

	/**
	 * Updates the Stripe customer.
	 *
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\Customers
	 */
	public function update(array $arguments = [])
	{
		return $this->handleRequest('POST', "customers/{$this->id}", $arguments);
	}

	/**
	 * Deletes the Stripe customer.
	 *
	 * @return bool
	 */
	public function delete()
	{
		$this->handleRequest('DELETE', "customers/{$this->id}");

		return true;
	}

}
