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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class WebhookEndpoints extends Api
{
    /**
     * Creates a new webhook endpoint.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('webhook_endpoints', $parameters);
    }

    /**
     * Retrieves an existing webhook endpoint.
     *
     * @param  string  $webhookEndpointId
     * @return array
     */
    public function find($webhookEndpointId)
    {
        return $this->_get("webhook_endpoints/{$webhookEndpointId}");
    }

    /**
     * Updates an existing webhook endpoint.
     *
     * @param  string  $webhookEndpointId
     * @param  array  $parameters
     * @return array
     */
    public function update($webhookEndpointId, array $parameters = [])
    {
        return $this->_post("webhook_endpoints/{$webhookEndpointId}", $parameters);
    }

    /**
     * Deletes an existing webhook endpoint.
     *
     * @param  string  $webhookEndpointId
     * @return array
     */
    public function delete($webhookEndpointId)
    {
        return $this->_delete("webhook_endpoints/{$webhookEndpointId}");
    }

    /**
     * Lists all webhook endpoints.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('webhook_endpoints', $parameters);
    }
}
