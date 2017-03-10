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

class TransferReversals extends Api
{
    /**
     * Creates a new transfer reversal.
     *
     * @param  string  $transfer
     * @param  array  $parameters
     * @return array
     */
    public function create($transfer, array $parameters = [])
    {
        return $this->_post("transfers/{$transfer}/reversals", $parameters);
    }

    /**
     * Retrieves an existing transfer reversal.
     *
     * @param  string  $transfer
     * @param  string  $reversal
     * @return array
     */
    public function find($transfer, $reversal)
    {
        return $this->_get("transfers/{$transfer}/reversals/{$reversal}");
    }

    /**
     * Updates an existing transfer reversal.
     *
     * @param  string  $transfer
     * @param  string  $reversal
     * @param  array  $parameters
     * @return array
     */
    public function update($transfer, $reversal, array $parameters = [])
    {
        return $this->_post("transfers/{$transfer}/reversals/{$reversal}", $parameters);
    }

    /**
     * Lists all transfer reversals.
     *
     * @param  string  $transfer
     * @param  array  $parameters
     * @return array
     */
    public function all($transfer, array $parameters = [])
    {
        return $this->_get("transfers/{$transfer}/reversals", $parameters);
    }
}
