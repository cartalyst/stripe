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
 * @version    2.0.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Skus extends Api
{
    /**
     * Creates a new sku.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('skus', $parameters);
    }

    /**
     * Retrieves an existing sku.
     *
     * @param  string  $skuId
     * @return array
     */
    public function find($skuId)
    {
        return $this->_get("skus/{$skuId}");
    }

    /**
     * Updates an existing sku.
     *
     * @param  string  $skuId
     * @param  array  $parameters
     * @return array
     */
    public function update($skuId, array $parameters = [])
    {
        return $this->_post("skus/{$skuId}", $parameters);
    }

    /**
     * Deletes an existing sku.
     *
     * @param  string  $skuId
     * @return array
     */
    public function delete($skuId)
    {
        return $this->_delete("skus/{$skuId}");
    }

    /**
     * Returns a list of all the skus.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('skus', $parameters);
    }
}
