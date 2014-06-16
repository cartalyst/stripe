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

use InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Stripe {

	/**
	 * The Guzzle client.
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

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
	protected $version;

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
	 * Cached manifests data.
	 *
	 * @var array
	 */
	protected $manifests = [];

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
		// Initialize the Guzzle client
		$this->client = new Client;

		// Set the Stripe API key for authentication
		$this->setStripeKey($stripeKey);

		// Set the client user agent
		$this->setHeaders([
			'User-Agent' => 'cartalyst-stripe-php',
		]);

		$this->setVersion($version ?: '2014-05-19');

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
	 * @return void
	 */
	public function setStripeKey($stripeKey)
	{
		$this->stripeKey = $stripeKey;

		$this->client->setDefaultOption('auth', [
			$stripeKey, null,
		]);
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
	 * @return void
	 */
	public function setVersion($version)
	{
		$this->version = $version;
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
	 * @return void
	 */
	public function setManifestPath($manifestPath)
	{
		$this->manifestPath = $manifestPath;
	}

	/**
	 * Returns the Guzzle client headers.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->client->getDefaultOption('headers');
	}

	/**
	 * Sets the Guzzle client headers.
	 *
	 * @param  array  $headers
	 * @return void
	 */
	public function setHeaders(array $headers = [])
	{
		$this->client->setDefaultOption('headers', $headers);
	}

	/**
	 * Dynamically handle missing methods.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __call($method, array $arguments = [])
	{
		if ($this->manifestExists($method))
		{
			return $this->handleRequest($method);
		}

		throw new InvalidArgumentException("Undefined method [{$method}] called.");
	}

	/**
	 * Handles the current request.
	 *
	 * @param  string  $method
	 * @return \GuzzleHttp\Command\Guzzle\GuzzleClient
	 */
	protected function handleRequest($method)
	{
		$manifest = $this->getManifestPayload($method);

		return new GuzzleClient($this->client, new Description($manifest));
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
		return array_merge($this->getManifest(), [
			'operations' => $this->getRequestManifestPayload($method),
		]);
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

	protected function getRequestManifestPayload($method)
	{
		if ( ! $manifest = array_get($this->manifests, $method))
		{
			$manifest = require $this->getRequestManifestPath($method);

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
