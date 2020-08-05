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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class Subscriptions extends AbstractApi
{
    /**
     * Creates a new subscription on the given customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(string $customerId, array $parameters = []): ApiResponse
    {
        $parameters['customer'] = $customerId;

        return $this->_post('subscriptions', $parameters);
    }

    /**
     * Retrieves an existing subscription from the given customer.
     *
     * @param string $subscriptionId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $subscriptionId): ApiResponse
    {
        return $this->_get("subscriptions/{$subscriptionId}");
    }

    /**
     * Updates an existing subscription from the given customer.
     *
     * @param string $subscriptionId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $subscriptionId, array $parameters = []): ApiResponse
    {
        return $this->_post("subscriptions/{$subscriptionId}", $parameters);
    }

    /**
     * Cancels an existing subscription from the given customer.
     *
     * @param string $subscriptionId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function cancel(string $subscriptionId, $parameters = []): ApiResponse
    {
        return $this->_delete("subscriptions/{$subscriptionId}", $parameters);
    }

    public function cancelAtPeriodEnd(string $subscriptionId): ApiResponse
    {
        return $this->update($subscriptionId, ['cancel_at_period_end' => true]);
    }

    /**
     * Reactivates a canceled subscription.
     *
     * @param string $subscriptionId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function reactivate(string $subscriptionId, array $parameters = []): ApiResponse
    {
        if (! isset($parameters['plan'])) {
            $subscription = $this->find($subscriptionId);

            $parameters['plan'] = $subscription['plan']['id'];
        }

        $parameters['cancel_at_period_end'] = false;

        return $this->update($subscriptionId, $parameters);
    }

    /**
     * Applies the given discount on the given subscription.
     *
     * @param string $subscriptionId
     * @param string $couponId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function applyDiscount(string $subscriptionId, string $couponId): ApiResponse
    {
        return $this->update($subscriptionId, [
            'coupon' => $couponId,
        ]);
    }

    /**
     * Deletes an existing subscription discount.
     *
     * @param string $subscriptionId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function deleteDiscount(string $subscriptionId): ApiResponse
    {
        return $this->_delete("subscriptions/{$subscriptionId}/discount");
    }

    /**
     * Lists all subscriptions.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('subscriptions', $parameters);
    }
}
