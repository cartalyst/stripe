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
     * @param  string  $customer
     * @return array
     */
    public function find($customer)
    {
        return $this->_get("customers/{$customer}");
    }

    /**
     * Updates an existing customer.
     *
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function update($customer, array $parameters = [])
    {
        return $this->_post("customers/{$customer}", $parameters);
    }

    /**
     * Deletes an existing customer.
     *
     * @param  string  $customer
     * @return array
     */
    public function delete($customer)
    {
        return $this->_delete("customers/{$customer}");
    }

    /**
     * Applies the given discount on the given customer.
     *
     * @param  string  $customer
     * @param  string  $coupon
     * @return array
     */
    public function applyDiscount($customer, $coupon)
    {
        return $this->update($customer, compact('coupon'));
    }

    /**
     * Deletes an existing customer discount.
     *
     * @param  string  $customer
     * @return array
     */
    public function deleteDiscount($customer)
    {
        return $this->_delete("customers/{$customer}/discount");
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
