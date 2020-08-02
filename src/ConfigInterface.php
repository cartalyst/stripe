<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
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
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function setApiKey(string $apiKey): self;

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
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function setApiVersion(string $apiVersion): self;

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
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function setAccountId(?string $accountId): self;

    /**
     * Returns the application's information, if set.
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
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function setAppInfo(string $appName, ?string $appVersion = null, ?string $appUrl = null, ?string $appPartnerId = null): self;
}
