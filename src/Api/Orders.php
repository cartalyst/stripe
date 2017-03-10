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
     * @param  string  $order
     * @return array
     */
    public function find($order)
    {
        return $this->_get("orders/{$order}");
    }

    /**
     * Updates an existing order.
     *
     * @param  string  $order
     * @param  array  $parameters
     * @return array
     */
    public function update($order, array $parameters = [])
    {
        return $this->_post("orders/{$order}", $parameters);
    }

    /**
     * Pays the given order.
     *
     * @param  string  $order
     * @param  array  $parameters
     * @return array
     */
    public function pay($order, array $parameters = [])
    {
        return $this->_post("orders/{$order}/pay", $parameters);
    }

    /**
     * Returns the given order.
     *
     * @param  string  $order
     * @param  array  $items
     * @return array
     */
    public function returnItems($order, array $items = [])
    {
        return $this->_post("orders/{$order}/returns", compact('items'));
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
