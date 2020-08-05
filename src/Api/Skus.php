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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class Skus extends AbstractApi
{
    /**
     * Creates a new sku.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('skus', $parameters);
    }

    /**
     * Retrieves an existing sku.
     *
     * @param string $skuId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $skuId): ApiResponse
    {
        return $this->_get("skus/{$skuId}");
    }

    /**
     * Updates an existing sku.
     *
     * @param string $skuId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $skuId, array $parameters = []): ApiResponse
    {
        return $this->_post("skus/{$skuId}", $parameters);
    }

    /**
     * Deletes an existing sku.
     *
     * @param string $skuId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function delete(string $skuId): ApiResponse
    {
        return $this->_delete("skus/{$skuId}");
    }

    /**
     * Returns a list of all the skus.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('skus', $parameters);
    }
}
