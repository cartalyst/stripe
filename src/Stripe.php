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

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Stripe {

	/**
	 * The Guzzle Client.
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

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
	 * Constructor.
	 *
	 * @param  string  $stripeKey
	 * @param  string  $version
	 * @param  string  $manifestPath
	 * @return void
	 */
	public function __construct($stripeKey, $version = null, $manifestPath = null)
	{
		$options = [
			'user_agent' => 'cartalyst-stripe-api (Cartalyst.com)',
			'defaults' => [
				'auth' => [
					$stripeKey, null,
				],
			],
		];

		$this->client = new Client($options);

		$this->setVersion($version ?: '2014-05-19');

		$this->setManifestPath($manifestPath ?: __DIR__.'/Manifests');
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
	 * Dynamically handle missing methods.
	 *
	 * @param  string  $method
	 * @param  array  $arguments
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __call($method, array $arguments = [])
	{
		// Check if the manifest file for this request exists
		if ($this->manifestExists($method))
		{
			return $this->getClient('customers');
		}

		throw new \InvalidArgumentException("Undefined method [{$method}] called.");
	}

	/**
	 * Returns the Guzzle Client.
	 *
	 * @param  string  $method
	 * @return \GuzzleHttp\Command\Guzzle\GuzzleClient
	 */
	protected function getClient($method)
	{
		$manifest = $this->getManifest($method);

		return new GuzzleClient($this->client, new Description($manifest));
	}

	/**
	 * Returns the appropriate manifest for the current request.
	 *
	 * @param  string  $method
	 * @return array
	 */
	protected function getManifest($method)
	{
		$versionedPath = $this->getVersionedManifestPath();

		$errors = require_once "{$versionedPath}/Errors.php";

		return array_merge(require_once "{$versionedPath}/Manifest.php", [
			'operations' => require_once $this->getRequestManifest($method),
		]);
	}

	/**
	 * Returns the versioned manifests path.
	 *
	 * @return string
	 */
	protected function getVersionedManifestPath()
	{
		return "{$this->getManifestPath()}/{$this->getVersion()}";
	}

	/**
	 * Returns the request manifest file path.
	 *
	 * @param  string  $method
	 * @return string
	 */
	protected function getRequestManifest($method)
	{
		$method = ucwords($method);

		return "{$this->getVersionedManifestPath()}/{$method}.php";
	}

	/**
	 * Checks if the manifest file exists.
	 *
	 * @param  string  $method.
	 * @return bool
	 */
	protected function manifestExists($method)
	{
		return file_exists($this->getRequestManifest($method));
	}

}
