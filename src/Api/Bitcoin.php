<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Bitcoin extends Api
{
    /**
     * Creates a new bitcoin receiver.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('bitcoin/receivers', $parameters);
    }

    /**
     * Retrieves the bitcoin receiver with the given ID.
     *
     * @param  string  $receiverId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($receiverId)
    {
        return $this->_get("bitcoin/receivers/{$receiverId}");
    }

    /**
     * Lists all bitcoin receivers.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('bitcoin/receivers', $parameters);
    }
}
