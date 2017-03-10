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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Subscriptions extends Api
{
    /**
     * Creates a new subscription on the given customer.
     *
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function create($customer, array $parameters = [])
    {
        return $this->_post("customers/{$customer}/subscriptions", $parameters);
    }

    /**
     * Retrieves an existing subscription from the given customer.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @return array
     */
    public function find($customer, $subscription)
    {
        return $this->_get("customers/{$customer}/subscriptions/{$subscription}");
    }

    /**
     * Updates an existing subscription from the given customer.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @param  array  $parameters
     * @return array
     */
    public function update($customer, $subscription, array $parameters = [])
    {
        return $this->_post("customers/{$customer}/subscriptions/{$subscription}", $parameters);
    }

    /**
     * Cancels an existing subscription from the given customer.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @param  bool  $atPeriodEnd
     * @return array
     */
    public function cancel($customer, $subscription, $atPeriodEnd = false)
    {
        return $this->_delete("customers/{$customer}/subscriptions/{$subscription}", [
            'at_period_end' => (bool) $atPeriodEnd,
        ]);
    }

    /**
     * Reactivates an existing canceled subscription from the given customer.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @param  array  $attributes
     * @return array
     */
    public function reactivate($customer, $subscription, array $attributes = [])
    {
        if (! isset($attributes['plan'])) {
            $currentSubscription = $this->find($customer, $subscription);

            $attributes['plan'] = $currentSubscription['plan']['id'];
        }

        return $this->update($customer, $subscription, $attributes);
    }

    /**
     * Applies the given discount on the given subscription.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @param  string  $coupon
     * @return array
     */
    public function applyDiscount($customer, $subscription, $coupon)
    {
        return $this->update($customer, $subscription, compact('coupon'));
    }

    /**
     * Deletes an existing subscription discount.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @return array
     */
    public function deleteDiscount($customer, $subscription)
    {
        return $this->_delete("customers/{$customer}/subscriptions/{$subscription}/discount");
    }

    /**
     * Lists all subscriptions from the given customer.
     *
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function all($customer, array $parameters = [])
    {
        $parameters = array_merge($parameters, compact('customer'));

        return $this->_get('subscriptions', $parameters);
    }
}
