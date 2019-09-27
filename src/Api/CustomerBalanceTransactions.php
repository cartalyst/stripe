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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class CustomerBalanceTransactions extends Api
{
    /**
     * Creates a new customer balance transaction.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function create($customerId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}/balance_transactions", $parameters);
    }

    /**
     * Retrieves an existing customer balance transaction.
     *
     * @param  string  $customerId
     * @param  string  $transactionId
     * @return array
     */
    public function find($customerId, $transactionId)
    {
        return $this->_get("customers/{$customerId}/balance_transactions/{$transactionId}");
    }

    /**
     * Updates an existing customer balance transaction.
     *
     * @param  string  $customerId
     * @param  string  $transactionId
     * @param  array  $parameters
     * @return array
     */
    public function update($customerId, $transactionId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}/balance_transactions/{$transactionId}", $parameters);
    }

    /**
     * Lists all the balance transactions for the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function all($customerId, array $parameters = [])
    {
        return $this->_get("customers/{$customerId}/balance_transactions", $parameters);
    }
}
