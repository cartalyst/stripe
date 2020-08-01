<?php

declare(strict_types=1);

/*
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
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Recipients extends Api
{
    /**
     * Creates a new recipient.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('recipients', $parameters);
    }

    /**
     * Retrieves an existing recipient.
     *
     * @param string $recipientId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $recipientId): ApiResponse
    {
        return $this->_get("recipients/{$recipientId}");
    }

    /**
     * Updates an existing recipient.
     *
     * @param string $recipientId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $recipientId, array $parameters = []): ApiResponse
    {
        return $this->_post("recipients/{$recipientId}", $parameters);
    }

    /**
     * Deletes an existing recipient.
     *
     * @param string $recipientId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $recipientId): ApiResponse
    {
        return $this->_delete("recipients/{$recipientId}");
    }

    /**
     * Lists all recipients.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('recipients', $parameters);
    }
}
