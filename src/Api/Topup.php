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

class Topup extends Api
{
    /**
     * Creates a new top-up.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('topups', $parameters);
    }

    /**
     * Retrieves an existing top-up.
     *
     * @param  string  $topupId
     * @return array
     */
    public function find($topupId)
    {
        return $this->_get("topups/{$topupId}");
    }

    /**
     * Updates an existing top-up.
     *
     * @param  string  $topupId
     * @param  array  $parameters
     * @return array
     */
    public function update($topupId, array $parameters = [])
    {
        return $this->_post("topups/{$topupId}", $parameters);
    }

    /**
     * Cancels an existing top-up.
     *
     * @param  string  $topupId
     * @return array
     */
    public function cancel($topupId)
    {
        return $this->_post("topups/{$topupId}/cancel");
    }

    /**
     * Deletes an existing top-up.
     *
     * @param  string  $topupId
     * @return array
     */
    public function delete($topupId)
    {
        return $this->_delete("topups/{$topupId}");
    }

    /**
     * Lists all top-ups.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('topups', $parameters);
    }
}
