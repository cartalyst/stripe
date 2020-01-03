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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Coupons extends Api
{
    /**
     * Creates a new coupon.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('coupons', $parameters);
    }

    /**
     * Retrieves an existing coupon.
     *
     * @param  string  $couponId
     * @return array
     */
    public function find($couponId)
    {
        return $this->_get("coupons/{$couponId}");
    }

    /**
     * Updates an existing coupon.
     *
     * @param  string  $couponId
     * @param  array  $parameters
     * @return array
     */
    public function update($couponId, array $parameters = [])
    {
        return $this->_post("coupons/{$couponId}", $parameters);
    }

    /**
     * Deletes an existing coupon.
     *
     * @param  string  $couponId
     * @return array
     */
    public function delete($couponId)
    {
        return $this->_delete("coupons/{$couponId}");
    }

    /**
     * Lists all coupons.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('coupons', $parameters);
    }
}
