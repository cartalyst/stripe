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

class Bitcoin extends Api
{
    /**
     * Creates a new bitcoin receiver.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('bitcoin/receivers', $parameters);
    }

    /**
     * Retrieves the bitcoin receiver with the given ID.
     *
     * @param  string  $receiver
     * @return array
     */
    public function find($receiver)
    {
        return $this->_get("bitcoin/receivers/{$receiver}");
    }

    /**
     * Lists all bitcoin receivers.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('bitcoin/receivers', $parameters);
    }
}
