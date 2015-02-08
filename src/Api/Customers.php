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
        return $this->_post('v1/customers', $parameters);
    }

    /**
     * Retrieves an existing customer.
     *
     * @param  string  $customerId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($customerId)
    {
        return $this->_get("v1/customers/{$customerId}");
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
        return $this->_post("v1/customers/{$customerId}", $parameters);
    }

    /**
     * Deletes an existing customer.
     *
     * @param  string  $customerId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($customerId)
    {
        return $this->_delete("v1/customers/{$customerId}");
    }

    /**
     * Lists all customers.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/customers', $parameters);
    }
}
