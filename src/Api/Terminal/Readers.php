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

namespace Cartalyst\Stripe\Api\Terminal;

use Cartalyst\Stripe\Api\AbstractApi;
use Cartalyst\Stripe\Api\ApiResponse;

class Readers extends AbstractApi
{
    /**
     * Creates a new terminal reader.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('terminal/readers', $parameters);
    }

    /**
     * Retrieves an existing terminal reader.
     *
     * @param string $readerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $readerId): ApiResponse
    {
        return $this->_get("terminal/readers/{$readerId}");
    }

    /**
     * Updates an existing terminal reader.
     *
     * @param string $readerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $readerId, array $parameters = []): ApiResponse
    {
        return $this->_post("terminal/readers/{$readerId}", $parameters);
    }

    /**
     * Deletes an existing terminal reader.
     *
     * @param string $readerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $readerId): ApiResponse
    {
        return $this->_delete("terminal/readers/{$readerId}");
    }

    /**
     * Lists all terminal readers.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('terminal/readers', $parameters);
    }
}
