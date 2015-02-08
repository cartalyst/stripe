<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Coupons extends Api
{
    /**
     * Creates a new coupon.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('v1/coupons', $parameters);
    }

    /**
     * Retrieves an existing coupon.
     *
     * @param  string  $couponId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($couponId)
    {
        return $this->_get("v1/coupons/{$couponId}");
    }

    /**
     * Updates an existing coupon.
     *
     * @param  string  $couponId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($couponId, array $parameters = [])
    {
        return $this->_post("v1/coupons/{$couponId}", $parameters);
    }

    /**
     * Deletes an existing coupon.
     *
     * @param  string  $couponId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($couponId)
    {
        return $this->_delete("v1/coupons/{$couponId}");
    }

    /**
     * Lists all coupons.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/coupons', $parameters);
    }
}
