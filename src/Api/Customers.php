<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Customers extends Api
{
    /**
     * Creates a new customer.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('customers', $parameters);
    }

    /**
     * Retrieves an existing customer.
     *
     * @param  string  $customerId
     * @return \GuzzleHttp\Message\ResponseInterface
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
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($customerId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}", $parameters);
    }

    /**
     * Deletes an existing customer.
     *
     * @param  string  $customerId
     * @return \GuzzleHttp\Message\ResponseInterface
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
     * @return \GuzzleHttp\Message\ResponseInterface
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
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function deleteDiscount($customerId)
    {
        return $this->_delete("customers/{$customerId}/discount");
    }

    /**
     * Lists all customers.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('customers', $parameters);
    }
}
