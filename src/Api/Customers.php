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

class Customers extends AbstractApi
{
    /**
     * Creates a new customer.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('customers', $parameters);
    }

    /**
     * Retrieves an existing customer.
     *
     * @param string $customerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $customerId): ApiResponse
    {
        return $this->_get("customers/{$customerId}");
    }

    /**
     * Updates an existing customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $customerId, array $parameters = []): ApiResponse
    {
        return $this->_post("customers/{$customerId}", $parameters);
    }

    /**
     * Deletes an existing customer.
     *
     * @param string $customerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $customerId): ApiResponse
    {
        return $this->_delete("customers/{$customerId}");
    }

    /**
     * Applies the given discount on the given customer.
     *
     * @param string $customerId
     * @param string $couponId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function applyDiscount(string $customerId, string $couponId): ApiResponse
    {
        return $this->update($customerId, [
            'coupon' => $couponId,
        ]);
    }

    /**
     * Deletes an existing customer discount.
     *
     * @param string $customerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function deleteDiscount(string $customerId): ApiResponse
    {
        return $this->_delete("customers/{$customerId}/discount");
    }

    /**
     * Lists all customers.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('customers', $parameters);
    }
}
