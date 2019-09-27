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

class Disputes extends Api
{
    /**
     * Retrieves an existing dispute.
     *
     * @param  string  $disputeId
     * @return array
     */
    public function find($disputeId)
    {
        return $this->_get("disputes/{$disputeId}");
    }

    /**
     * Updates an existing dispute.
     *
     * @param  string  $dispute
     * @param  array  $parameters
     * @return array
     */
    public function update($dispute, array $parameters = [])
    {
        return $this->_post("disputes/{$dispute}", $parameters);
    }

    /**
     * Closes an existing dispute.
     *
     * @param  string  $dispute
     * @return array
     */
    public function close($dispute)
    {
        return $this->_post("disputes/{$dispute}/close");
    }

    /**
     * Lists all disputes.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('disputes', $parameters);
    }
}
