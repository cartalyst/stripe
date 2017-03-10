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
     * @param  string  $product
     * @return array
     */
    public function find($product)
    {
        return $this->_get("products/{$product}");
    }

    /**
     * Updates an existing product.
     *
     * @param  string  $product
     * @param  array  $parameters
     * @return array
     */
    public function update($product, array $parameters = [])
    {
        return $this->_post("products/{$product}", $parameters);
    }

    /**
     * Deletes an existing product.
     *
     * @param  string  $product
     * @return array
     */
    public function delete($product)
    {
        return $this->_delete("products/{$product}");
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
