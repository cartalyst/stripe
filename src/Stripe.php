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

use Cartalyst\Stripe\Http\HttpClient;

class Stripe {

	/**
	 * The Http Client.
	 *
	 * @var \Cartalyst\Stripe\Http\HttpClient
	 */
	protected $httpClient;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Http\HttpClient  $httpClient
	 * @return void
	 */
	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Returns the Http Client.
	 *
	 * @return \Cartalyst\Stripe\Http\HttpClient
	 */
	public function getHttpClient()
	{
		return $this->httpClient;
	}

	/**
	 * Sets the Http Client.
	 *
	 * @param  \Cartalyst\Stripe\Http\HttpClient  $httpClient
	 * @return void
	 */
	public function setHttpClient(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Dynamically handle missing methods.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __call($method, $arguments)
	{
		$class = '\\Cartalyst\\Stripe\\Api\\'.ucwords($method);

		if (class_exists($class))
		{
			return new $class($this);
		}

		throw new \InvalidArgumentException("Undefined method [{$method}] called.");
	}

}
