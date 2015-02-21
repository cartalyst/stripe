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

class Balance extends Api
{
    /**
     * Retrieives the current account balance.
     *
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function current()
    {
        return $this->_get('balance');
    }

    /**
     * Retrieves the balance transaction for the given id.
     *
     * @param  string  $transactionId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($transactionId)
    {
        return $this->_get("balance/history/{$transactionId}");
    }

    /**
     * Lists all transactions
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('balance/history', $parameters);
    }
}
