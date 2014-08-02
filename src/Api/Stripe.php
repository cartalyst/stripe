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
use InvalidArgumentException;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;

class Stripe {

	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected $stripeKey;

	/**
	 * The Stripe API version.
	 *
	 * @var string
	 */
	protected $version = '2014-06-17';

	/**
	 * The user agent.
	 *
	 * @var string
	 */
	protected $userAgent = 'Cartalyst-Stripe/1.0.0';

	/**
	 * The manifests path.
	 *
	 * @var string
	 */
	protected $manifestPath;

	/**
	 * Holds the main manifest data.
	 *
	 * @var array
	 */
	protected $manifest;

	/**
	 * The Cached manifests data.
	 *
	 * @var array
	 */
	protected $manifests = [];

	/**
	 * The headers to be sent to the Guzzle client.
	 *
	 * @var array
	 */
	protected $headers = [];

	/**
	 * Constructor.
	 *
	 * @param  string  $stripeKey
	 * @param  string  $version
	 * @param  string  $manifestPath
	 * @return void
	 */
	public function __construct($stripeKey, $version = null, $manifestPath = null)
	{
		// Set the Stripe API key for authentication
		$this->setStripeKey($stripeKey);

		// Set the version
		$this->setVersion($version ?: $this->version);

		// Set the manifest path
		$this->setManifestPath($manifestPath ?: __DIR__.'/Manifests');
	}

	/**
	 * Returns the Stripe API key.
	 *
	 * @return string
	 */
	public function getStripeKey()
	{
		return $this->stripeKey;
	}

	/**
	 * Sets the Stripe API key.
	 *
	 * @param  string  $stripeKey
	 * @return $this
	 */
	public function setStripeKey($stripeKey)
	{
		$this->stripeKey = $stripeKey;

		return $this;
	}

	/**
	 * Returns the version that's being used.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * Sets the version to be used.
	 *
	 * @param  string  $version
	 * @return $this
	 */
	public function setVersion($version)
	{
		$this->version = $version;

		$this->setHeaders([
			'Stripe-Version' => (string) $version,
		]);

		return $this;
	}

	/**
	 * Returns the user agent.
	 *
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}

	/**
	 * Sets the user agent.
	 *
	 * @param  string  $userAgent
	 * @return $this
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = $userAgent;

		return $this;
	}

	/**
	 * Returns the manifests path.
	 *
	 * @return string
	 */
	public function getManifestPath()
	{
		return $this->manifestPath;
	}

	/**
	 * Sets the manifests path.
	 *
	 * @param  string  $manifestPath
	 * @return $this
	 */
	public function setManifestPath($manifestPath)
	{
		$this->manifestPath = $manifestPath;

		return $this;
	}

	/**
	 * Returns the Guzzle client headers.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * Sets the Guzzle client headers.
	 *
	 * @param  array  $headers
	 * @return $this
	 */
	public function setHeaders(array $headers = [])
	{
		$this->headers = array_merge($this->headers, $headers);

		return $this;
	}

	/**
	 * Dynamically handle missing methods.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return mixed
	 */
	public function __call($method, array $arguments = [])
	{
		if (substr($method, -8) === 'Iterator')
		{
			$method = substr($method, 0, -8);

			return $this->handleIteratorRequest($method, $arguments);
		}

		return $this->handleRequest($method);
	}

	/**
	 * Handles an iterator request.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\ResourceIterator
	 */
	protected function handleIteratorRequest($method, array $arguments = [])
	{
		$client = $this->handleRequest($method);

		$command = $client->getCommand('all', array_get($arguments, 0, []));

		return new ResourceIterator($command, array_get($arguments, 1, []));
	}

	/**
	 * Handles the current request.
	 *
	 * @param  string  $method
	 * @return \Guzzle\Service\Client
	 * @throws \InvalidArgumentException
	 */
	protected function handleRequest($method)
	{
		if ( ! $this->manifestExists($method))
		{
			throw new InvalidArgumentException("Undefined method [{$method}] called.");
		}

		// Initialize the Guzzle client
		$client = new Client;

		// Set the client user agent
		$client->setUserAgent($this->getUserAgent(), true);

		// Set the authentication
		$client->setDefaultOption('auth', [
			$this->getStripeKey(), null,
		]);

		// Set the headers
		$client->setDefaultOption('headers', $this->getHeaders());

		// Get the Guzzle event dispatcher
		$dispatcher = $client->getEventDispatcher();

		// Register the error response plugin for our custom exceptions
		$dispatcher->addSubscriber(new ErrorResponsePlugin);

		// Set the manifest payload into the Guzzle client
		$manifest = $this->getManifestPayload($method);
		$client->setDescription(ServiceDescription::factory($manifest));

		// Return the Guzzle client
		return $client;
	}

	/**
	 * Returns the full versioned manifests path.
	 *
	 * @return string
	 */
	protected function getFullManifestPath()
	{
		return "{$this->getManifestPath()}/{$this->getVersion()}";
	}

	/**
	 * Returns the main manifest data.
	 *
	 * @return array
	 */
	protected function getManifest()
	{
		if ( ! $this->manifest)
		{
			$this->manifest = require_once "{$this->getFullManifestPath()}/Manifest.php";
		}

		return $this->manifest;
	}

	/**
	 * Returns the appropriate manifest for the current request.
	 *
	 * @param  string  $method
	 * @return array
	 */
	protected function getManifestPayload($method)
	{
		$operations = $this->getRequestManifestPayload($method);

		return array_merge($this->getManifest(), compact('operations'));
	}

	/**
	 * Returns the current request manifest file path.
	 *
	 * @param  string  $method
	 * @return string
	 */
	protected function getRequestManifestPath($method)
	{
		$method = ucwords($method);

		return "{$this->getFullManifestPath()}/{$method}.php";
	}

	/**
	 * Returns the current request manifest payload.
	 *
	 * @param  string  $method
	 * @return array
	 */
	protected function getRequestManifestPayload($method)
	{
		if ( ! $manifest = array_get($this->manifests, $method))
		{
			$errors = require $this->getRequestManifestPath('Errors');

			$manifest = require_once $this->getRequestManifestPath($method);

			array_set($this->manifests, $method, $manifest);
		}

		return $manifest;
	}

	/**
	 * Checks if the manifest file for the current request exists.
	 *
	 * @param  string  $method
	 * @return bool
	 */
	protected function manifestExists($method)
	{
		return file_exists($this->getRequestManifestPath($method));
	}

}
