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

class PaymentMethods extends AbstractApi
{
    /**
     * Creates a new payment method.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('payment_methods', $parameters);
    }

    /**
     * Retrieves an existing payment method.
     *
     * @param string $paymentMethodId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $paymentMethodId): ApiResponse
    {
        return $this->_get("payment_methods/{$paymentMethodId}");
    }

    /**
     * Attaches an existing payment method to the given customer.
     *
     * @param string $paymentMethodId
     * @param string $customerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function attach(string $paymentMethodId, $customerId): ApiResponse
    {
        return $this->_post("payment_methods/{$paymentMethodId}/attach", [
            'customer' => $customerId,
        ]);
    }

    /**
     * Detaches an existing payment method to the given customer.
     *
     * @param string $paymentMethodId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function detach(string $paymentMethodId): ApiResponse
    {
        return $this->_post("payment_methods/{$paymentMethodId}/detach");
    }

    /**
     * Updates an existing payment method.
     *
     * @param string $paymentMethodId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $paymentMethodId, array $parameters = []): ApiResponse
    {
        return $this->_post("payment_methods/{$paymentMethodId}", $parameters);
    }

    /**
     * Lists all payment methods.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('payment_methods', $parameters);
    }
}
