<?php namespace Cartalyst\Stripe\Models;
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
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Stripe\Stripe;

class Collection extends \Illuminate\Support\Collection {

	/**
	 * {@inheritDoc}
	 */
	protected $items;

	/**
	 * List of API response properties that'll be
	 * automatically converted into collections.
	 *
	 * @var array
	 */
	protected $collections = [];

	/**
	 * The Stripe API client instance.
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $apiClient;

	/**
	 * Returns the Stripe API client instance.
	 *
	 * @return \Cartalyst\Stripe\Stripe
	 */
	public function getApiClient()
	{
		return $this->apiClient;
	}

	/**
	 * Sets the Stripe API client instance.
	 *
	 * @param \Cartalyst\Stripe\Stripe  $client
	 * @return void
	 */
	public function setApiClient(Stripe $client)
	{
		$this->apiClient = $client;
	}

	/**
	 * Returns the given key value from the collection.
	 *
	 * @param  mixed  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		if (in_array($key, $this->collections) || array_key_exists($key, $this->collections))
		{
			if ($mappedKey = array_get($this->collections, $key, []))
			{
				$key = strstr($mappedKey, '.', true);

				$query = ltrim(strstr($mappedKey, '.'), '.');

				$data = array_get($this->get($key), $query, []);
			}
			else
			{
				$data = $this->get($key, []);
			}

			return new Collection($data);
		}

		if (method_exists($this, $method = "{$key}Attribute"))
		{
			return $this->{$method}($this->get($key));
		}

		return $this->get($key, null);
	}

}
