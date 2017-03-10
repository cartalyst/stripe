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
     * @param  string  $coupon
     * @return array
     */
    public function find($coupon)
    {
        return $this->_get("coupons/{$coupon}");
    }

    /**
     * Updates an existing coupon.
     *
     * @param  string  $coupon
     * @param  array  $parameters
     * @return array
     */
    public function update($coupon, array $parameters = [])
    {
        return $this->_post("coupons/{$coupon}", $parameters);
    }

    /**
     * Deletes an existing coupon.
     *
     * @param  string  $coupon
     * @return array
     */
    public function delete($coupon)
    {
        return $this->_delete("coupons/{$coupon}");
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
