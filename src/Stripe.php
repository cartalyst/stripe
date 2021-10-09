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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe;

use ReflectionClass;

class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '2.4.6';

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
        return $this->config->getApiKey();
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->config->setApiKey($apiKey);

        return $this;
    }

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->config->getApiVersion();
    }

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->config->setApiVersion($apiVersion);

        return $this;
    }

    /**
     * Sets the idempotency key.
     *
     * @param  string|null  $idempotencyKey
     * @return $this
     */
    public function idempotent($idempotencyKey)
    {
        $this->config->setIdempotencyKey($idempotencyKey);

        return $this;
    }

    /**
     * Sets the account id.
     *
     * @param  string|null  $accountId
     * @return $this
     */
    public function accountId($accountId)
    {
        $this->config->setAccountId($accountId);

        return $this;
    }

    /**
     * Returns the application's information.
     *
     * @return array|null
     */
    public function getAppInfo()
    {
        return $this->config->getAppInfo();
    }

    /**
     * Sets the application's information.
     *
     * @param string $appName
     * @param string $appVersion
     * @param string $appUrl
     * @param string $appPartnerId
     * @return $this
     */
    public function setAppInfo($appName, $appVersion = null, $appUrl = null, $appPartnerId = null)
    {
        return $this->config->setAppInfo($appName, $appVersion, $appUrl, $appPartnerId);
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
     * Disables the amount converter.
     *
     * @return void
     */
    public static function disableAmountConverter()
    {
        static::setAmountConverter(null);
    }

    /**
     * Returns the default amount converter.
     *
     * @return string
     */
    public static function getDefaultAmountConverter()
    {
        return '\\Cartalyst\\Stripe\\AmountConverter::convert';
    }

    /**
     * Sets the default amount converter;
     *
     * @return void
     */
    public static function setDefaultAmountConverter()
    {
        static::setAmountConverter(
            static::getDefaultAmountConverter()
        );
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function __call($method, array $parameters)
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

        if (class_exists($class) && ! (new ReflectionClass($class))->isAbstract()) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }
}
