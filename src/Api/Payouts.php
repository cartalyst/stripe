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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Payouts extends Api
{
    /**
     * Creates a new payout.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('payouts', $parameters);
    }

    /**
     * Retrieves an existing payout.
     *
     * @param  string  $payoutId
     * @return array
     */
    public function find($payoutId)
    {
        return $this->_get("payouts/{$payoutId}");
    }

    /**
     * Updates an existing payout.
     *
     * @param  string  $payoutId
     * @param  array  $parameters
     * @return array
     */
    public function update($payoutId, array $parameters = [])
    {
        return $this->_post("payouts/{$payoutId}", $parameters);
    }

    /**
     * Cancels the given payout.
     *
     * @param  string  $payoutId
     * @return array
     */
    public function cancel($payoutId)
    {
        return $this->_post("payouts/{$payoutId}/cancel");
    }

    /**
     * Lists all payouts.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('payouts', $parameters);
    }
}
