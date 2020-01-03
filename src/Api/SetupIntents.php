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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class SetupIntents extends Api
{
    /**
     * Creates a new setup intent.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('setup_intents', $parameters);
    }

    /**
     * Retrieves an existing setup intent.
     *
     * @param  string  $setupIntentId
     * @return array
     */
    public function find($setupIntentId)
    {
        return $this->_get("setup_intents/{$setupIntentId}");
    }

    /**
     * Updates an existing setup intents.
     *
     * @param  string  $setupIntentId
     * @param  array  $parameters
     * @return array
     */
    public function update($setupIntentId, array $parameters = [])
    {
        return $this->_post("setup_intents/{$setupIntentId}", $parameters);
    }

    /**
     * Confirm the given setup intent.
     *
     * @param  string  $setupIntentId
     * @param  array  $parameters
     * @return array
     */
    public function confirm($setupIntentId, array $parameters = [])
    {
        return $this->_post("setup_intents/{$setupIntentId}/confirm", $parameters);
    }

    /**
     * Cancels the given setup intent.
     *
     * @param  string  $setupIntentId
     * @param  array  $parameters
     * @return array
     */
    public function cancel($setupIntentId, array $parameters = [])
    {
        return $this->_post("setup_intents/{$setupIntentId}/cancel", $parameters);
    }

    /**
     * Lists all setup intents.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('setup_intents', $parameters);
    }
}
