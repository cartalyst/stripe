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

class PaymentMethods extends Api
{
    /**
     * Creates a new payment method.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('payment_methods', $parameters);
    }

    /**
     * Retrieves an existing payment method.
     *
     * @param  string  $paymentMethodId
     * @return array
     */
    public function find($paymentMethodId)
    {
        return $this->_get("payment_methods/{$paymentMethodId}");
    }

    /**
     * Attaches an existing payment method to the given customer.
     *
     * @param  string  $paymentMethodId
     * @param  string  $customerId
     * @return array
     */
    public function attach($paymentMethodId, $customerId)
    {
        return $this->_post("payment_methods/{$paymentMethodId}/attach", [
            'customer' => $customerId,
        ]);
    }

    /**
     * Detaches an existing payment method to the given customer.
     *
     * @param  string  $paymentMethodId
     * @return array
     */
    public function detach($paymentMethodId)
    {
        return $this->_post("payment_methods/{$paymentMethodId}/detach");
    }

    /**
     * Updates an existing payment method.
     *
     * @param  string  $paymentMethodId
     * @param  array  $parameters
     * @return array
     */
    public function update($paymentMethodId, array $parameters = [])
    {
        return $this->_post("payment_methods/{$paymentMethodId}", $parameters);
    }

    /**
     * Lists all payment methods.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('payment_methods', $parameters);
    }
}
