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

class ApplicationFeeRefunds extends Api
{
    /**
     * Creates a new application fee refund.
     *
     * @param  string  $fee
     * @param  array  $parameters
     * @return array
     */
    public function create($fee, array $parameters = [])
    {
        return $this->_post("application_fees/{$fee}/refunds", $parameters);
    }

    /**
     * Retrieves an existing application fee refund.
     *
     * @param  string  $fee
     * @param  string  $refund
     * @return array
     */
    public function find($fee, $refund)
    {
        return $this->_get("application_fees/{$fee}/refunds/{$refund}");
    }

    /**
     * Updates an existing application fee refund.
     *
     * @param  string  $fee
     * @param  string  $refund
     * @param  array  $parameters
     * @return array
     */
    public function update($fee, $refund, array $parameters = [])
    {
        return $this->_post("application_fees/{$fee}/refunds/{$refund}", $parameters);
    }

    /**
     * Lists all application fee refunds.
     *
     * @param  string  $fee
     * @param  array  $parameters
     * @return array
     */
    public function all($fee, array $parameters = [])
    {
        return $this->_get("application_fees/{$fee}/refunds", $parameters);
    }
}
