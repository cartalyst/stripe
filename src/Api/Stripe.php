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
	protected $version = '2014-07-26';

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
	 * The cached manifests data.
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
			return $this->handleIteratorRequest($method, $arguments);
		}

		elseif (str_singular($method) === $method)
		{
			return $this->handleSingleRequest($method, $arguments);
		}

		return $this->handleRequest($method);
	}

	/**
	 * Handles a single request.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return \Guzzle\Service\Client
	 * @throws \InvalidArgumentException
	 */
	protected function handleSingleRequest($method, array $arguments = [])
	{
		// Pluralize the method name
		$pluralMethod = str_plural($method);

		// Get the request manifest payload data
		$manifest = $this->getRequestManifestPayload($pluralMethod);

		// Validate the method
		if ( ! $this->manifestExists($pluralMethod) || ! array_get($manifest, 'find'))
		{
			throw new InvalidArgumentException("Undefined method [{$method}] called.");
		}

		// Get the required parameters for the request
		$required = array_where(array_get($manifest, 'find.parameters'), function($key, $value)
		{
			return $value['required'] === true;
		});

		// Prepare the arguments for the request
		$arguments = array_combine(
			array_keys($required),
			count($required) === 1 ? (array) $arguments[0] : $arguments
		);

		// Execute the request
		return $this->handleRequest($pluralMethod)->find($arguments);
	}

	/**
	 * Handles an iterator request.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return \Cartalyst\Stripe\Api\ResourceIterator
	 * @throws \InvalidArgumentException
	 */
	protected function handleIteratorRequest($method, array $arguments = [])
	{
		$method = substr($method, 0, -8);

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
		$payload = $this->buildPayload($method);
		$client->setDescription(ServiceDescription::factory($payload));

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
	 * Returns the given request manifest file path.
	 *
	 * @param  string  $file
	 * @return string
	 */
	protected function getManifestFilePath($file)
	{
		$file = ucwords($file);

		return "{$this->getFullManifestPath()}/{$file}.php";
	}

	/**
	 * Returns the current request payload.
	 *
	 * @param  string  $method
	 * @return array
	 */
	protected function buildPayload($method)
	{
		$manifest = $this->getRequestManifestPayload('manifest', false);

		$operations = $this->getRequestManifestPayload($method);

		return array_merge($manifest, compact('operations'));
	}

	/**
	 * Returns the given file manifest data.
	 *
	 * @param  string  $file
	 * @param  bool  $includeErrors
	 * @return array
	 */
	protected function getRequestManifestPayload($file, $includeErrors = true)
	{
		$file = ucwords($file);

		if ( ! $manifest = array_get($this->manifests, $file))
		{
			if ($includeErrors)
			{
				$errors = $this->getRequestManifestPayload('errors', false);
			}

			$manifest = require_once $this->getManifestFilePath($file);

			array_set($this->manifests, $file, $manifest);
		}

		return $manifest;
	}

	/**
	 * Checks if the manifest file for the current request exists.
	 *
	 * @param  string  $file
	 * @return bool
	 */
	protected function manifestExists($file)
	{
		return file_exists($this->getManifestFilePath($file));
	}

}
