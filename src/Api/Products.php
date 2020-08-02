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

class Products extends AbstractApi
{
    /**
     * Creates a new product.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('products', $parameters);
    }

    /**
     * Retrieves an existing product.
     *
     * @param string $productId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $productId): ApiResponse
    {
        return $this->_get("products/{$productId}");
    }

    /**
     * Updates an existing product.
     *
     * @param string $productId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $productId, array $parameters = []): ApiResponse
    {
        return $this->_post("products/{$productId}", $parameters);
    }

    /**
     * Deletes an existing product.
     *
     * @param string $productId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $productId): ApiResponse
    {
        return $this->_delete("products/{$productId}");
    }

    /**
     * Returns a list of all the products.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('products', $parameters);
    }
}
