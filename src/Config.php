<?php

declare(strict_types=1);

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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
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
     * The managed account id.
     *
     * @var string|null
     */
    protected $accountId;

    /**
     * The application's information.
     *
     * @var array|null
     */
    protected $appInfo;

    /**
     * Constructor.
     *
     * @param string $version
     * @param string $apiKey
     * @param string $apiVersion
     *
     * @return void
     */
    public function __construct(string $version, string $apiKey, string $apiVersion)
    {
        $this->setVersion($version);

        $this->setApiKey($apiKey);

        $this->setApiVersion($apiVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion(string $version): ConfigInterface
    {
        $this->version = $version;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiKey(string $apiKey): ConfigInterface
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiVersion(string $apiVersion): ConfigInterface
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountId(?string $accountId): ConfigInterface
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppInfo(): ?array
    {
        return $this->appInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppInfo(string $appName, ?string $appVersion = null, ?string $appUrl = null, ?string $appPartnerId = null): ConfigInterface
    {
        $this->appInfo = [
            'name'       => $appName,
            'version'    => $appVersion,
            'url'        => $appUrl,
            'partner_id' => $appPartnerId,
        ];

        return $this;
    }
}
