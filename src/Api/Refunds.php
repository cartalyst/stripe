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
 * @version    2.4.5
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Refunds extends Api
{
    /**
     * Creates a new refund.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post("refunds", $parameters);
    }

    /**
     * Retrieves an existing refund.
     *
     * @param  string|null  $refundId
     * @return array
     */
    public function find($refundId)
    {
        return $this->_get("refunds/{$refundId}");
    }

    /**
     * Updates an existing refund.
     *
     * @param  string  $refundId
     * @param  array  $parameters
     * @return array
     */
    public function update($refundId, array $parameters = [])
    {
        return $this->_post("refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all the refunds of the current Stripe account
     * or list all refunds for a given charge / payment intent.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('refunds', $parameters);
    }
}
