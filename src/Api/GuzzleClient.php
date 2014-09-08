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

use Guzzle\Service\Client;

class GuzzleClient extends Client {

	/**
	 * The Stripe API client instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $apiClient;

	/**
	 * Returns the Stripe API client instance.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	public function getApiClient()
	{
		return $this->apiClient;
	}

	/**
	 * Sets the Stripe API client instance.
	 *
	 * @param \Cartalyst\Stripe\Api\Stripe  $client
	 * @return void
	 */
	public function setApiClient(Stripe $client)
	{
		$this->apiClient = $client;
	}

}
