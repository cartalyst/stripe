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

class Products extends Api
{
    /**
     * Creates a new product.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('products', $parameters);
    }

    /**
     * Retrieves an existing product.
     *
     * @param  string  $productId
     * @return array
     */
    public function find($productId)
    {
        return $this->_get("products/{$productId}");
    }

    /**
     * Updates an existing product.
     *
     * @param  string  $productId
     * @param  array  $parameters
     * @return array
     */
    public function update($productId, array $parameters = [])
    {
        return $this->_post("products/{$productId}", $parameters);
    }

    /**
     * Deletes an existing product.
     *
     * @param  string  $productId
     * @return array
     */
    public function delete($productId)
    {
        return $this->_delete("products/{$productId}");
    }

    /**
     * Returns a list of all the products.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('products', $parameters);
    }
}
