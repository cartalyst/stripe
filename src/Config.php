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
 * @version    2.0.8
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

class Config implements ConfigInterface
{
    /**
     * The current package version.
     *
     * @var string
     */
    protected $version;

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
     * The idempotency key.
     *
     * @var string
     */
    protected $idempotencyKey;

    /**
     * The managed account id.
     *
     * @var string
     */
    protected $accountId;

    /**
     * Constructor.
     *
     * @param  string  $version
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     * @throws \RuntimeException
     */
    public function __construct($version, $apiKey, $apiVersion)
    {
        $this->setVersion($version);

        $this->setApiKey($apiKey ?: getenv('STRIPE_API_KEY'));

        $this->setApiVersion($apiVersion ?: getenv('STRIPE_API_VERSION') ?: '2016-07-06');

        if (! $this->apiKey) {
            throw new \RuntimeException('The Stripe API key is not defined!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdempotencyKey()
    {
        return $this->idempotencyKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdempotencyKey($idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;

        return $this;
    }

    /**
     * Returns the managed account id.
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Sets the managed account id.
     *
     * @param  string  $accountId
     * @return $this
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }
}
