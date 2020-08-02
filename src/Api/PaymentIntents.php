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

class PaymentIntents extends AbstractApi
{
    /**
     * Creates a new payment intent.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('payment_intents', $parameters);
    }

    /**
     * Retrieves an existing payment intent.
     *
     * @param string $paymentIntentId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $paymentIntentId): ApiResponse
    {
        return $this->_get("payment_intents/{$paymentIntentId}");
    }

    /**
     * Updates an existing payment intents.
     *
     * @param string $paymentIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $paymentIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("payment_intents/{$paymentIntentId}", $parameters);
    }

    /**
     * Confirm the given payment intent.
     *
     * @param string $paymentIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function confirm(string $paymentIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("payment_intents/{$paymentIntentId}/confirm", $parameters);
    }

    /**
     * Caputres the given payment intent.
     *
     * @param string $paymentIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function capture(string $paymentIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("payment_intents/{$paymentIntentId}/capture", $parameters);
    }

    /**
     * Cancels the given payment intent.
     *
     * @param string $paymentIntentId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function cancel(string $paymentIntentId, array $parameters = []): ApiResponse
    {
        return $this->_post("payment_intents/{$paymentIntentId}/cancel", $parameters);
    }

    /**
     * Lists all payment intents.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('payment_intents', $parameters);
    }
}
