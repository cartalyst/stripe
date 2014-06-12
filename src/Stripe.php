<?php namespace Cartalyst\Stripe;

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
	 * {inheritDoc}
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
