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

namespace Cartalyst\Stripe\Api;

class PaymentIntents extends Api
{
    /**
     * Creates a new payment intent.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('payment_intents', $parameters);
    }

    /**
     * Retrieves an existing payment intent.
     *
     * @param  string  $paymentIntentId
     * @return array
     */
    public function find($paymentIntentId)
    {
        return $this->_get("payment_intents/{$paymentIntentId}");
    }

    /**
     * Updates an existing payment intents.
     *
     * @param  string  $paymentIntentId
     * @param  array  $parameters
     * @return array
     */
    public function update($paymentIntentId, array $parameters = [])
    {
        return $this->_post("payment_intents/{$paymentIntentId}", $parameters);
    }

    /**
     * Confirm the given payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $parameters
     * @return array
     */
    public function confirm($paymentIntentId, array $parameters = [])
    {
        return $this->_post("payment_intents/{$paymentIntentId}/confirm", $parameters);
    }

    /**
     * Caputres the given payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $parameters
     * @return array
     */
    public function capture($paymentIntentId, array $parameters = [])
    {
        return $this->_post("payment_intents/{$paymentIntentId}/capture", $parameters);
    }

    /**
     * Cancels the given payment intent.
     *
     * @param  string  $paymentIntentId
     * @param  array  $parameters
     * @return array
     */
    public function cancel($paymentIntentId, array $parameters = [])
    {
        return $this->_post("payment_intents/{$paymentIntentId}/cancel", $parameters);
    }

    /**
     * Lists all payment intents.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('payment_intents', $parameters);
    }
}
