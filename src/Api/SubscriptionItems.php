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

class SubscriptionItems extends AbstractApi
{
    /**
     * Creates a new item an existing subscription.
     *
     * @param string $subscriptionId
     * @param string $planId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $subscriptionId, string $planId, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, [
            'subscription' => $subscriptionId,
            'plan'         => $planId,
        ]);

        return $this->_post('subscription_items', $parameters);
    }

    /**
     * Retrieves an existing subscription item.
     *
     * @param string $itemId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $itemId): ApiResponse
    {
        return $this->_get("subscription_items/{$itemId}");
    }

    /**
     * Updates an existing subscription item.
     *
     * @param string $itemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $itemId, array $parameters = []): ApiResponse
    {
        return $this->_post("subscription_items/{$itemId}", $parameters);
    }

    /**
     * Deletes an existing subscription item.
     *
     * @param string $itemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $itemId, array $parameters = []): ApiResponse
    {
        return $this->_delete("subscription_items/{$itemId}", $parameters);
    }

    /**
     * Lists all subscription items.
     *
     * @param string $subscriptionId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $subscriptionId, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, [
            'subscription' => $subscriptionId,
        ]);

        return $this->_get('subscription_items', $parameters);
    }
}
