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

class Coupons extends Api
{
    /**
     * Creates a new coupon.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('coupons', $parameters);
    }

    /**
     * Retrieves an existing coupon.
     *
     * @param string $couponId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $couponId): ApiResponse
    {
        return $this->_get("coupons/{$couponId}");
    }

    /**
     * Updates an existing coupon.
     *
     * @param string $couponId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $couponId, array $parameters = []): ApiResponse
    {
        return $this->_post("coupons/{$couponId}", $parameters);
    }

    /**
     * Deletes an existing coupon.
     *
     * @param string $couponId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $couponId): ApiResponse
    {
        return $this->_delete("coupons/{$couponId}");
    }

    /**
     * Lists all coupons.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('coupons', $parameters);
    }
}
