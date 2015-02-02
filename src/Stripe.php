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

use Doctrine\Common\Inflector\Inflector;
use Cartalyst\Stripe\Descriptions\Descriptor;

class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

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
    protected $apiVersion = '2015-01-26';

    /**
     * The headers to be sent to the Guzzle client.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The cached request clients.
     *
     * @var array
     */
    protected $cachedClient = [];

    /**
     * The Description util class instance.
     *
     * @var \Cartalyst\Stripe\Util\Description
     */
    protected $description;

    /**
     * Constructor.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     */
    public function __construct($apiKey = null, $apiVersion = null)
    {
        // Create the Descriptor instance
        $this->descriptor = new Descriptor;

        // Set the Stripe API key for authentication
        $this->setApiKey(
            $apiKey ?: getenv('STRIPE_API_KEY')
        );

        // Set the Stripe API version
        $this->setApiVersion(
            $apiVersion ?: getenv('STRIPE_API_VERSION') ?: $this->apiVersion
        );
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
        return $this->apiKey;
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     * @throws \RuntimeException
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        if ( ! $this->apiKey) {
            throw new \RuntimeException('The Stripe API key is not defined!');
        }

        return $this;
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
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = (string) $apiVersion;

        $this->descriptor->setApiVersion($this->apiVersion);

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
        die;
        if ($this->isIteratorRequest($method)) {
            return $this->handleIteratorRequest($method, $arguments);
        } elseif ($this->isSingleRequest($method)) {
            return $this->handleSingleRequest($method, $arguments);
        }

        return $this->handleRequest($method);
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

    /**
     * Handles an iterator request.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return \Cartalyst\Stripe\Api\ResourceIterator
     */
    protected function handleIteratorRequest($method, array $arguments)
    {
        $client = $this->handleRequest(substr($method, 0, -8));

        $command = $client->getCommand('all', isset($arguments[0]) ? $arguments[0] : []);

        return new ResourceIterator($command, isset($arguments[1]) ? $arguments[1] : []);
    }

    /**
     * Determines if the request is a single request.
     *
     * @return bool
     */
    protected function isSingleRequest($method)
    {
        return (Inflector::singularize($method) === $method && $this->description->exists(Inflector::pluralize($method)));
    }

    /**
     * Handles a single request.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return \Guzzle\Service\Client
     * @throws \InvalidArgumentException
     */
    protected function handleSingleRequest($method, array $arguments)
    {
        // Check if we have any arguments
        if (empty($arguments)) {
            throw new \InvalidArgumentException('Not enough arguments provided!');
        }

        // Get the request description payload data
        $description = $this->description->getPayload(Inflector::pluralize($method));

        // Get the find method
        $method = isset($description['find']) ? $description['find'] : null;

        // Get the 'find' method parameters from the description
        if ( ! $method) {
            throw new \InvalidArgumentException('Undefined method [find] called.');
        }

        // Get the parameters
        $parameters = isset($method['parameters']) ? $method['parameters'] : [];

        // Get the required parameters for the request
        $required = array_where($parameters, function ($key, $value) {
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
     * Handles the current request.
     *
     * @param  string  $method
     * @return \Guzzle\Service\Client
     * @throws \InvalidArgumentException
     */
    protected function handleRequest($method)
    {
        // Is there a cached Guzzle client instance for this method?
        if ( ! isset($this->cachedClient[$method])) {
            // Check if the description file for the given method exists
            if ( ! $this->description->exists($method)) {
                throw new \InvalidArgumentException("Undefined method [{$method}] called.");
            }

            // Create a new Guzzle client instance for this request and cache it
            $this->cachedClient[$method] = $this->makeGuzzleClient($method);
        }

        // Return the Guzzle client instance
        return $this->cachedClient[$method];
    }

    /**
     * Creates a new Guzzle client instance for the given method.
     *
     * @param  string  $method
     * @return \Cartalyst\Stripe\Client
     */
    protected function makeGuzzleClient($method)
    {
        // Create a new Guzzle instance
        $client = new Client($this);

        // Set the headers
        $client->setHeaders($this->getHeaders());

        // Set the description payload into the Guzzle client
        $client->setDescription(
            $this->descriptor->buildPayload($method)
        );

        return $client;
    }
}
