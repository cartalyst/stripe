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

use Cartalyst\Stripe\Api\Api;
use Cartalyst\Stripe\Api\ApiResponse;

class Locations extends Api
{
    /**
     * Creates a new terminal location.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('terminal/locations', $parameters);
    }

    /**
     * Retrieves an existing terminal location.
     *
     * @param string $locationId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $locationId): ApiResponse
    {
        return $this->_get("terminal/locations/{$locationId}");
    }

    /**
     * Updates an existing terminal location.
     *
     * @param string $locationId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $locationId, array $parameters = []): ApiResponse
    {
        return $this->_post("terminal/locations/{$locationId}", $parameters);
    }

    /**
     * Deletes an existing terminal location.
     *
     * @param string $locationId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $locationId): ApiResponse
    {
        return $this->_delete("terminal/locations/{$locationId}");
    }

    /**
     * Lists all terminal locations.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('terminal/locations', $parameters);
    }
}
