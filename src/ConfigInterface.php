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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe;

interface ConfigInterface
{
    /**
     * Returns the current package version.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Sets the current package version.
     *
     * @param  string  $version
     * @return $this
     */
    public function setVersion($version);

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey();

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     */
    public function setApiKey($apiKey);

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion);

    /**
     * Returns the idempotency key.
     *
     * @return string
     */
    public function getIdempotencyKey();

    /**
     * Sets the idempotency key.
     *
     * @param  string  $idempotencyKey
     * @return $this
     */
    public function setIdempotencyKey($idempotencyKey);
}
