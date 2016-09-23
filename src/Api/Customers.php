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
 * @version    2.0.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Customers extends Api
{
    /**
     * Creates a new customer.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('customers', $parameters);
    }

    /**
     * Retrieves an existing customer.
     *
     * @param  string  $customerId
     * @return array
     */
    public function find($customerId)
    {
        return $this->_get("customers/{$customerId}");
    }

    /**
     * Updates an existing customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function update($customerId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}", $parameters);
    }

    /**
     * Deletes an existing customer.
     *
     * @param  string  $customerId
     * @return array
     */
    public function delete($customerId)
    {
        return $this->_delete("customers/{$customerId}");
    }

    /**
     * Applies the given discount on the given customer.
     *
     * @param  string  $customerId
     * @param  string  $couponId
     * @return array
     */
    public function applyDiscount($customerId, $couponId)
    {
        return $this->update($customerId, [
            'coupon' => $couponId,
        ]);
    }

    /**
     * Deletes an existing customer discount.
     *
     * @param  string  $customerId
     * @return array
     */
    public function deleteDiscount($customerId)
    {
        return $this->_delete("customers/{$customerId}/discount");
    }

    /**
     * Lists all customers.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('customers', $parameters);
    }
}
