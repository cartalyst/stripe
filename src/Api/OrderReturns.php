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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class OrderReturns extends Api
{
    /**
     * Retrieves an existing order return.
     *
     * @param  string  $orderReturnId
     * @return array
     */
    public function find($orderReturnId)
    {
        return $this->_get("order_returns/{$orderReturnId}");
    }

    /**
     * Returns a list of all the order returns.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('order_returns', $parameters);
    }
}
