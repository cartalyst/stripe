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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class BalanceTransactions extends Api
{
    /**
     * Retrieves an existing balance transaction.
     *
     * @param  string  $transactionId
     * @return array
     */
    public function find($transactionId)
    {
        return $this->_get("balance_transactions/{$transactionId}");
    }

    /**
     * Lists all the balance transactions.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get("balance_transactions", $parameters);
    }
}
