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
	protected $version = '2014-05-19';

	/**
	 * Constructor.
	 *
	 * @param  string  $stripeKey
	 * @return void
	 */
	public function __construct($stripeKey)
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
	}

	/**
	 * Returns the Stripe version being used.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * Sets the Stripe version to be used.
	 *
	 * @param  string  $version
	 * @return void
	 */
	public function setVersion($version)
	{
		$this->version = $version;
	}

	public function getManifestPath()
	{
		return __DIR__.'/Manifests';
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
		// Check if the manifest file for this request exists.
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
		$manifestPath = $this->getManifestPath();

		$versionedPath = "{$manifestPath}/{$this->version}";

		$errors = require_once "{$versionedPath}/Errors.php";

		return array_merge(require_once "{$versionedPath}/Manifest.php", [
			'operations' => require_once $this->manifestMethodFilePath($method),
		]);
	}

	protected function manifestMethodFilePath($method)
	{
		$method = ucwords($method);

		return "{$this->getManifestPath()}/{$this->getVersion()}/{$method}.php";
	}

	protected function manifestExists($method)
	{
		return file_exists($this->manifestMethodFilePath($method));
	}

}
