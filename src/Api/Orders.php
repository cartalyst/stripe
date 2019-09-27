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

class Orders extends Api
{
    /**
     * Creates a new order.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('orders', $parameters);
    }

    /**
     * Retrieves an existing order.
     *
     * @param  string  $orderId
     * @return array
     */
    public function find($orderId)
    {
        return $this->_get("orders/{$orderId}");
    }

    /**
     * Updates an existing order.
     *
     * @param  string  $orderId
     * @param  array  $parameters
     * @return array
     */
    public function update($orderId, array $parameters = [])
    {
        return $this->_post("orders/{$orderId}", $parameters);
    }

    /**
     * Pays the given order.
     *
     * @param  string  $orderId
     * @param  array  $parameters
     * @return array
     */
    public function pay($orderId, array $parameters = [])
    {
        return $this->_post("orders/{$orderId}/pay", $parameters);
    }

    /**
     * Returns the given order.
     *
     * @param  string  $orderId
     * @param  array  $items
     * @return array
     */
    public function returnItems($orderId, array $items = [])
    {
        return $this->_post("orders/{$orderId}/returns", compact('items'));
    }

    /**
     * Returns a list of all the orders.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('orders', $parameters);
    }
}
