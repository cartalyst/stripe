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

class Recipients extends Api
{
    /**
     * Creates a new recipient.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('v1/recipients', $parameters);
    }

    /**
     * Retrieves an existing recipient.
     *
     * @param  string  $recipientId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($recipientId)
    {
        return $this->_get("v1/recipients/{$recipientId}");
    }

    /**
     * Updates an existing recipient.
     *
     * @param  string  $recipientId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($recipientId, array $parameters = [])
    {
        return $this->_post("v1/recipients/{$recipientId}", $parameters);
    }

    /**
     * Deletes an existing recipient.
     *
     * @param  string  $recipientId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($recipientId)
    {
        return $this->_delete("v1/recipients/{$recipientId}");
    }

    /**
     * Lists all recipients.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/recipients', $parameters);
    }
}
