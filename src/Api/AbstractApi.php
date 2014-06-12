<?php namespace Cartalyst\Stripe\Api;

use Cartalyst\Stripe\Stripe;

abstract class AbstractApi {

	/**
	 *
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $client;

	/**
	 *
	 *
	 * @var \Cartalyst\Stripe\Http\HttpClient
	 */
	protected $httpClient;

	/**
	 *
	 *
	 * @var arry
	 */
	protected $attributes = [];

	public function __construct(Stripe $client)
	{
		$this->client = $client;

		$this->httpClient = $this->client->getHttpClient();
	}

	/**
	 * Sends a GET request
	 *
	 * @param  string  $url
	 * @param  array  $arguments
	 * @param  array  $headers
	 * @return \GuzzleHttp\Http
	 */
	protected function get($url, array $arguments = [], array $headers = [])
	{
		$response = $this->client->getHttpClient()->get($url, $arguments, $headers);

		$this->attributes = $response->json();
	}


	public function __get($key)
	{
		return array_get($this->attributes, $key, 'fooxxx');
	}

}
