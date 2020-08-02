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

class Orders extends AbstractApi
{
    /**
     * Creates a new order.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('orders', $parameters);
    }

    /**
     * Retrieves an existing order.
     *
     * @param string $orderId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $orderId): ApiResponse
    {
        return $this->_get("orders/{$orderId}");
    }

    /**
     * Updates an existing order.
     *
     * @param string $orderId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $orderId, array $parameters = []): ApiResponse
    {
        return $this->_post("orders/{$orderId}", $parameters);
    }

    /**
     * Pays the given order.
     *
     * @param string $orderId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function pay(string $orderId, array $parameters = []): ApiResponse
    {
        return $this->_post("orders/{$orderId}/pay", $parameters);
    }

    /**
     * Returns the given order.
     *
     * @param string $orderId
     * @param array  $items
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function returnItems(string $orderId, array $items = []): ApiResponse
    {
        return $this->_post("orders/{$orderId}/returns", [
            'items' => $items,
        ]);
    }

    /**
     * Returns a list of all the orders.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('orders', $parameters);
    }
}
