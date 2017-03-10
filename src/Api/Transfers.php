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

class Transfers extends Api
{
    /**
     * Creates a new transfer.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('transfers', $parameters);
    }

    /**
     * Retrieves an existing transfer.
     *
     * @param  string  $transfer
     * @return array
     */
    public function find($transfer)
    {
        return $this->_get("transfers/{$transfer}");
    }

    /**
     * Updates an existing transfer.
     *
     * @param  string  $transfer
     * @param  array  $parameters
     * @return array
     */
    public function update($transfer, array $parameters = [])
    {
        return $this->_post("transfers/{$transfer}", $parameters);
    }

    /**
     * Lists all transfers.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('transfers', $parameters);
    }
}
