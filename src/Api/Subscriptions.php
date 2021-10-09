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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Subscriptions extends Api
{
    /**
     * Creates a new subscription on the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function create($customerId, array $parameters = [])
    {
        $parameters['customer'] = $customerId;

        return $this->_post('subscriptions', $parameters);
    }

    /**
     * Retrieves an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return array
     */
    public function find($customerId, $subscriptionId)
    {
        return $this->_get("subscriptions/{$subscriptionId}");
    }

    /**
     * Updates an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  array  $parameters
     * @return array
     */
    public function update($customerId, $subscriptionId, array $parameters = [])
    {
        return $this->_post("subscriptions/{$subscriptionId}", $parameters);
    }

    /**
     * Cancels an existing subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  bool  $atPeriodEnd
     * @return array
     */
    public function cancel($customerId, $subscriptionId, $atPeriodEnd = false)
    {
        return $this->_delete("subscriptions/{$subscriptionId}", [
            'at_period_end' => (bool) $atPeriodEnd,
        ]);
    }

    /**
     * Reactivates an existing canceled subscription from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  array  $attributes
     * @return array
     */
    public function reactivate($customerId, $subscriptionId, array $attributes = [])
    {
        if (! isset($attributes['plan'])) {
            $subscription = $this->find($customerId, $subscriptionId);

            $attributes['plan'] = $subscription['plan']['id'];
        }

        return $this->update($customerId, $subscriptionId, $attributes);
    }

    /**
     * Applies the given discount on the given subscription.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @param  string  $couponId
     * @return array
     */
    public function applyDiscount($customerId, $subscriptionId, $couponId)
    {
        return $this->update($customerId, $subscriptionId, [
            'coupon' => $couponId,
        ]);
    }

    /**
     * Deletes an existing subscription discount.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return array
     */
    public function deleteDiscount($customerId, $subscriptionId)
    {
        return $this->_delete("subscriptions/{$subscriptionId}/discount");
    }

    /**
     * Lists all subscriptions for the given customer or
     * all the subscriptions for the Stripe account.
     *
     * @param  string|null  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function all($customerId = null, array $parameters = [])
    {
        if ($customerId !== null) {
            $parameters = array_merge($parameters, [
                'customer' => $customerId,
            ]);
        }

        return $this->_get('subscriptions', $parameters);
    }
}
