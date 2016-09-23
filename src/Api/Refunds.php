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

class Refunds extends Api
{
    /**
     * Creates a new refund for the given charge.
     *
     * @param  string  $chargeId
     * @param  int  $amount
     * @param  array  $parameters
     * @return array
     */
    public function create($chargeId, $amount = null, array $parameters = [])
    {
        $parameters = array_merge($parameters, array_filter(compact('amount')));

        return $this->_post("charges/{$chargeId}/refunds", $parameters);
    }

    /**
     * Retrieves an existing refund from the given charge.
     *
     * @param  string  $chargeId
     * @param  string  $refundId
     * @return array
     */
    public function find($chargeId, $refundId)
    {
        return $this->_get("charges/{$chargeId}/refunds/{$refundId}");
    }

    /**
     * Updates an existing refund on the given charge.
     *
     * @param  string  $chargeId
     * @param  string  $refundId
     * @param  array  $parameters
     * @return array
     */
    public function update($chargeId, $refundId, array $parameters = [])
    {
        return $this->_post("charges/{$chargeId}/refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all refunds for the given charge.
     *
     * @param  string  $chargeId
     * @param  array  $parameters
     * @return array
     */
    public function all($chargeId, array $parameters = [])
    {
        return $this->_get("charges/{$chargeId}/refunds", $parameters);
    }
}
