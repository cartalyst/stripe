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
 * @version    2.0.8
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
     * @param  string  $transferId
     * @param  array  $parameters
     * @return array
     */
    public function create($transferId, array $parameters = [])
    {
        return $this->_post("transfers/{$transferId}/reversals", $parameters);
    }

    /**
     * Retrieves an existing transfer reversal.
     *
     * @param  string  $transferId
     * @param  string  $transferReversalId
     * @return array
     */
    public function find($transferId, $transferReversalId)
    {
        return $this->_get("transfers/{$transferId}/reversals/{$transferReversalId}");
    }

    /**
     * Updates an existing transfer reversal.
     *
     * @param  string  $transferId
     * @param  string  $transferReversalId
     * @param  array  $parameters
     * @return array
     */
    public function update($transferId, $transferReversalId, array $parameters = [])
    {
        return $this->_post("transfers/{$transferId}/reversals/{$transferReversalId}", $parameters);
    }

    /**
     * Lists all transfer reversals.
     *
     * @param  string  $transferId
     * @param  array  $parameters
     * @return array
     */
    public function all($transferId, array $parameters = [])
    {
        return $this->_get("transfers/{$transferId}/reversals", $parameters);
    }
}
