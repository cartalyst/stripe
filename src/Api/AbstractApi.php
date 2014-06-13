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

use Cartalyst\Stripe\Stripe;

abstract class AbstractApi {

	/**
	 * The Stripe client.
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $client;

	/**
	 * The Http Client.
	 *
	 * @var \Cartalyst\Stripe\Http\HttpClient
	 */
	protected $httpClient;

	/**
	 * The request response.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Stripe  $client
	 * @return void
	 */
	public function __construct(Stripe $client)
	{
		$this->client = $client;

		$this->httpClient = $this->client->getHttpClient();
	}

	/**
	 * Sends a GET request.
	 *
	 * @param  string  $url
	 * @param  array  $arguments
	 * @return \GuzzleHttp\Message\Response
	 */
	protected function _get($url, array $arguments = [])
	{
		$response = $this->httpClient->get($url, ['query' => $arguments]);

		$this->attributes = $response->json();

		return $response;
	}

	/**
	 * Sends a POST request.
	 *
	 * @param  string  $url
	 * @param  mixed  $arguments
	 * @return \GuzzleHttp\Message\Response
	 */
	protected function _post($url, $arguments = null)
	{
		$response = $this->httpClient->post($url, ['query' => $arguments]);

		$this->attributes = $response->json();

		return $response;
	}

	/**
	 * Sends a DELETE request
	 *
	 * @param  string  $url
	 * @return \GuzzleHttp\Message\Response
	 */
	protected function _delete($url)
	{
		return $this->httpClient->delete($url);
	}

	/**
	 * Returns a response attribute.
	 *
	 * @param  string  $key
	 * @return string|null
	 */
	public function __get($key)
	{
		return array_get($this->attributes, $key, null);
	}

}
