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
 * @version    2.0.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Recipients extends Api
{
    /**
     * Creates a new recipient.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('recipients', $parameters);
    }

    /**
     * Retrieves an existing recipient.
     *
     * @param  string  $recipientId
     * @return array
     */
    public function find($recipientId)
    {
        return $this->_get("recipients/{$recipientId}");
    }

    /**
     * Updates an existing recipient.
     *
     * @param  string  $recipientId
     * @param  array  $parameters
     * @return array
     */
    public function update($recipientId, array $parameters = [])
    {
        return $this->_post("recipients/{$recipientId}", $parameters);
    }

    /**
     * Deletes an existing recipient.
     *
     * @param  string  $recipientId
     * @return array
     */
    public function delete($recipientId)
    {
        return $this->_delete("recipients/{$recipientId}");
    }

    /**
     * Lists all recipients.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('recipients', $parameters);
    }
}
