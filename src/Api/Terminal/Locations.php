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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api\Terminal;

use Cartalyst\Stripe\Api\Api;

class Locations extends Api
{
    /**
     * Creates a new terminal location.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('terminal/locations', $parameters);
    }

    /**
     * Retrieves an existing terminal location.
     *
     * @param  string  $locationId
     * @return array
     */
    public function find($locationId)
    {
        return $this->_get("terminal/locations/{$locationId}");
    }

    /**
     * Updates an existing terminal location.
     *
     * @param  string  $locationId
     * @param  array  $parameters
     * @return array
     */
    public function update($locationId, array $parameters = [])
    {
        return $this->_post("terminal/locations/{$locationId}", $parameters);
    }

    /**
     * Deletes an existing terminal location.
     *
     * @param  string  $locationId
     * @return array
     */
    public function delete($locationId)
    {
        return $this->_delete("terminal/locations/{$locationId}");
    }

    /**
     * Lists all terminal locations.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('terminal/locations', $parameters);
    }
}
