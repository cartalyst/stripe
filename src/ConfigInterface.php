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

interface ConfigInterface
{
    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey(): string;

    /**
     * Sets the Stripe API key.
     *
     * @param string $apiKey
     *
     * @return \Cartalyst\Config\ConfigInterface
     */
    public function setApiKey(string $apiKey): ConfigInterface;

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion(): string;

    /**
     * Sets the Stripe API version.
     *
     * @param string $apiVersion
     *
     * @return \Cartalyst\Config\ConfigInterface
     */
    public function setApiVersion(string $apiVersion): ConfigInterface;

    /**
     * Returns the managed account id.
     *
     * @return string|null
     */
    public function getAccountId(): ?string;

    /**
     * Sets the managed account id.
     *
     * @param string|null $accountId
     *
     * @return \Cartalyst\Config\ConfigInterface
     */
    public function setAccountId(?string $accountId): ConfigInterface;

    /**
     * Returns the application's information.
     *
     * @return array|null
     */
    public function getAppInfo(): ?array;

    /**
     * Sets the application's information.
     *
     * @param string      $appName
     * @param string|null $appVersion
     * @param string|null $appUrl
     * @param string|null $appPartnerId
     *
     * @return \Cartalyst\Config\ConfigInterface
     */
    public function setAppInfo(string $appName, ?string $appVersion = null, ?string $appUrl = null, ?string $appPartnerId = null): ConfigInterface;
}
