<?php namespace Cartalyst\Stripe\Api;

use Cartalyst\Stripe\Client;

abstract class AbstractApi {

	/**
	 *
	 *
	 * @var  \Cartalyst\Stripe\Client
	 */
	protected $client;

	protected $attributes = [];

	public function __construct(Client $client)
	{
		$this->client = $client;
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
		$arguments = $this->prepareArguments($arguments);

		$response = $this->client->getHttpClient()->get($url, $arguments, $headers);

		$this->attributes = $response->json();
	}

	protected function prepareArguments($arguments)
	{
		$stripeKey = \Config::get('services.stripe.secret');

		return array_merge($arguments, [
			'auth' => [
				$stripeKey, null,
			],
		]);
	}

	public function __get($key)
	{
		return array_get($this->attributes, $key, 'fooxxx');
	}

}
