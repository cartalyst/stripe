<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.1.0';

    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * The amount converter class and method name.
     *
     * @var string
     */
    protected static $amountConverter = '\\Cartalyst\\Stripe\\AmountConverter::convert';

    /**
     * Constructor.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     */
    public function __construct($apiKey = null, $apiVersion = null)
    {
        $this->config = new Config(self::VERSION, $apiKey, $apiVersion);
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
     * Returns the Config repository instance.
     *
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param  \Cartalyst\Stripe\ConfigInterface  $config
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config->api_key;
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->config->api_key = $apiKey;

        return $this;
    }

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->config->api_version;
    }

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->config->api_version = $apiVersion;

        return $this;
    }

    /**
     * Sets the idempotency key.
     *
     * @param  string  $idempotencyKey
     * @return $this
     */
    public function idempotent($idempotencyKey)
    {
        $this->config->idempotency_key = $idempotencyKey;

        return $this;
    }

    /**
     * Returns the amount converter class and method name.
     *
     * @return string
     */
    public static function getAmountConverter()
    {
        return static::$amountConverter;
    }

    /**
     * Sets the amount converter class and method name.
     *
     * @param  $amountConverter  string
     * @return void
     */
    public static function setAmountConverter($amountConverter)
    {
        static::$amountConverter = $amountConverter;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function __call($method, array $parameters = [])
    {
        if ($this->isIteratorRequest($method)) {
            $apiInstance = $this->getApiInstance(substr($method, 0, -8));

            return (new Pager($apiInstance))->fetch($parameters);
        }

        return $this->getApiInstance($method);
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
     * Returns the Api class instance for the given method.
     *
     * @param  string  $method
     * @return \Cartalyst\Stripe\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method)
    {
        $class = "\\Cartalyst\\Stripe\\Api\\".ucwords($method);

        if (class_exists($class)) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }
}
