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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class CustomerBalanceTransactions extends AbstractApi
{
    /**
     * Creates a new customer balance transaction.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(string $customerId, array $parameters = []): ApiResponse
    {
        return $this->_post("customers/{$customerId}/balance_transactions", $parameters);
    }

    /**
     * Retrieves an existing customer balance transaction.
     *
     * @param string $customerId
     * @param string $transactionId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $customerId, string $transactionId): ApiResponse
    {
        return $this->_get("customers/{$customerId}/balance_transactions/{$transactionId}");
    }

    /**
     * Updates an existing customer balance transaction.
     *
     * @param string $customerId
     * @param string $transactionId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $customerId, string $transactionId, array $parameters = []): ApiResponse
    {
        return $this->_post("customers/{$customerId}/balance_transactions/{$transactionId}", $parameters);
    }

    /**
     * Lists all the balance transactions for the given customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(string $customerId, array $parameters = []): ApiResponse
    {
        return $this->_get("customers/{$customerId}/balance_transactions", $parameters);
    }
}
