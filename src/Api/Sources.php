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
 * @version    2.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Sources extends Api
{
    /**
     * Creates a new source on the given customer.
     *
     * @param  string|array  $parameters
     * @return array
     */
    public function create($parameters = [])
    {
        return $this->_post('sources', $parameters);
    }

    /**
     * Retrieves an existing source.
     *
     * @param  string  $sourceId
     * @return array
     */
    public function find($sourceId)
    {
        return $this->_get("sources/{$sourceId}");
    }

    /**
     * Updates an existing source.
     *
     * @param  string  $sourceId
     * @param  array  $parameters
     * @return array
     */
    public function update($sourceId, array $parameters = [])
    {
        return $this->_post("sources/{$sourceId}", $parameters);
    }
}
