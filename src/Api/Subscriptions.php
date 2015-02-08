<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Subscriptions extends Api
{
    /**
     * Creates a new subscription on the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create($customerId, array $parameters = [])
    {
        return $this->_post("v1/customers/{$customerId}/subscriptions", $parameters);
    }

    /**
     * Retrieves an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($customerId, $subscriptionId)
    {
        return $this->_get("v1/customers/{$customerId}/subscriptions/{$subscriptionId}");
    }

    /**
     * Updates an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($customerId, $subscriptionId, array $parameters = [])
    {
        return $this->_post("v1/customers/{$customerId}/subscriptions/{$subscriptionId}", $parameters);
    }

    /**
     * Cancels an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  bool  $atPeriodEnd
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function cancel($customerId, $subscriptionId, $atPeriodEnd = true)
    {
        return $this->_delete("v1/customers/{$customerId}/subscriptions/{$subscriptionId}", [
            'query' => [
                'at_period_end' => $atPeriodEnd,
            ],
        ]);
    }

    /**
     * Reactivates an existing canceled subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function reactivate($customerId, $subscriptionId)
    {
        $subscription = $this->find($customerId, $subscription);

        return $this->update($customerId, $subscriptionId, [
            'query' => [
                'plan' => $subscription['plan']['id'],
            ],
        ]);
    }

    /**
     * Lists all subscriptions from the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all($customerId, array $parameters = [])
    {
        return $this->_get("v1/{$customerId}/subscriptions", $parameters);
    }
}
