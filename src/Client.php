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

use Guzzle\Common\Event;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;

class Client extends \Guzzle\Service\Client {

	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected $apiKey;

	/**
	 * The Stripe API version.
	 *
	 * @var string
	 */
	protected $apiVersion;

	/**
	 * The Stripe API client instance.
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $apiClient;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Stripe  $stripe
	 * @return void
	 */
	public function __construct(Stripe $stripe)
	{
		parent::__construct();

		// Set the Stripe API
		$this->setApiClient($stripe);

		// Set the API key
		$this->setApiKey($stripe->getApiKey());

		// Set the API version
		$this->setApiVersion($stripe->getApiVersion());

		// Set the client user agent
		$this->setUserAgent('Cartalyst-Stripe/'.$stripe::VERSION, true);

		// Get the Guzzle event dispatcher
		$dispatcher = $this->getEventDispatcher();

		// Register the error response plugin for our custom exceptions
		$dispatcher->addSubscriber(new ErrorResponsePlugin());

		// Listen to the "command.before_send" event fired by Guzzle
		$dispatcher->addListener('command.before_send', [ $this, 'commandBeforeSend' ]);

		// Listen to the "command.after_prepare" event fired by Guzzle
		$dispatcher->addListener('command.after_prepare', [ $this, 'commandAfterPrepare' ]);
	}

	/**
	 * Returns the Stripe API key.
	 *
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * Sets the Stripe API key.
	 *
	 * @param  string  $apiKey
	 * @return void
	 */
	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * Returns the Stripe API version.
	 *
	 * @return string
	 */
	public function getApiVersion()
	{
		return $this->apiVersion;
	}

	/**
	 * Sets the Stripe API version.
	 *
	 * @param  string  $apiVersion
	 * @return void
	 */
	public function setApiVersion($apiVersion)
	{
		$this->apiVersion = $apiVersion;

		$this->setDefaultOption('headers', [ 'Stripe-Version' => $this->apiVersion ]);
	}

	/**
	 * Sets the headers.
	 *
	 * @param  array  $headers
	 * @return void
	 */
	public function setHeaders(array $headers)
	{
		$this->setDefaultOption('headers', $headers);
	}

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
	 * @param  \Cartalyst\Stripe\Stripe  $client
	 * @return void
	 */
	public function setApiClient(Stripe $client)
	{
		$this->apiClient = $client;
	}

	/**
	 * Listen to the "command.after_prepare" event fired by Guzzle.
	 *
	 * @param  \Guzzle\Common\Event  $event
	 * @return void
	 */
	public function commandAfterPrepare(Event $event)
	{
		$event['command']->getRequest()->getQuery()->setAggregator(
			new QueryAggregator
		);
	}

	/**
	 * Listen to the "command.before_send" event fired by Guzzle.
	 *
	 * @param  \Guzzle\Common\Event  $event
	 * @return void
	 */
	public function commandBeforeSend(Event $event)
	{
		$event['command']->getRequest()->setAuth($this->apiKey);
	}

}
