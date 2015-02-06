<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

use Cartalyst\Stripe\Api;
use Doctrine\Common\Inflector\Inflector;
use Cartalyst\Stripe\Listeners\ErrorListener;

class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The Guzzle client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The Stripe API version.
     *
     * @var string
     */
    protected $apiVersion = '2015-01-26';

    /**
     * Constructor.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     */
    public function __construct($apiKey = null, $apiVersion = null)
    {
        $this->client = new HttpClient($apiKey, $apiVersion);

        $this->client->setUserAgentVersion(self::VERSION);
    }

    /**
     * Create a new Stripe API instance.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return \Cartalyst\Stripe\Stripe
     */
    public static function make($apiKey = null, $apiVersion = null)
    {
        return new static($apiKey, $apiVersion);
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->client->getApiKey();
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->client->setApiKey($apiKey);

        return $this;
    }
    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->client->getApiVersion();
    }

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->client->setApiVersion($apiVersion);

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return \Cartalyst\Stripe\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    public function __call($method, array $arguments = [])
    {
        // if ($this->isSingleRequest($method)) {
        //     return $this->handleSingleRequest($method);
        // } elseif ($this->isIteratorRequest($method)) {
        //     return $this->handleIteratorRequest($method);
        // }

        if ($class = $this->validateRequest($method)) {
            return new $class($this->client);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }

    /**
     * Determines if the request is a single request.
     *
     * @return bool
     */
    protected function isSingleRequest($method)
    {
        return (Inflector::singularize($method) == $method && $this->checkApiClassExists(Inflector::pluralize($method)));
    }

    /**
     * Determines if the request is an iterator request.
     *
     * @return bool
     */
    protected function isIteratorRequest($method)
    {
        return substr($method, -8) === 'Iterator';
    }

    protected function getApiClassNamespace($method)
    {
        return "\\Cartalyst\\Stripe\\Api\\".ucwords($method);
    }

    protected function checkApiClassExists($method)
    {
        return class_exists($this->getApiClassNamespace($method));
    }

    protected function validateRequest($method)
    {
        # check if it's an iterator request : Stripe::customersIterator();
        # check if it's a single request    : Stripe::customer(:id);

        $class = "\\Cartalyst\\Stripe\\Api\\".ucwords($method);

        if (class_exists($class)) {
            return $class;
        }
    }
}
