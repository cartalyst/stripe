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

namespace Cartalyst\Stripe\Api;

class SetupIntents extends Api
{
    /**
     * Creates a new setup intent.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('setup_intents', $parameters);
    }

    /**
     * Retrieves an existing setup intent.
     *
     * @param string $setupIntentId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $setupIntentId): ApiResponse
    {
        return $this->_get("setup_intents/{$setupIntentId}");
    }

    /**
     * Updates an existing setup intents.
     *
     * @param string $setupIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $setupIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("setup_intents/{$setupIntentId}", $parameters);
    }

    /**
     * Confirm the given setup intent.
     *
     * @param string $setupIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function confirm(string $setupIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("setup_intents/{$setupIntentId}/confirm", $parameters);
    }

    /**
     * Cancels the given setup intent.
     *
     * @param string $setupIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function cancel(string $setupIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("setup_intents/{$setupIntentId}/cancel", $parameters);
    }

    /**
     * Lists all setup intents.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('setup_intents', $parameters);
    }
}
