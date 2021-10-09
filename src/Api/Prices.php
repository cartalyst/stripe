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

namespace Cartalyst\Stripe\Api;

class Prices extends Api
{
    /**
     * Creates a new price.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('prices', $parameters);
    }

    /**
     * Retrieves an existing price.
     *
     * @param  string  $priceId
     * @return array
     */
    public function find($priceId)
    {
        return $this->_get("prices/{$priceId}");
    }

    /**
     * Updates an existing price.
     *
     * @param  string  $priceId
     * @param  array  $parameters
     * @return array
     */
    public function update($priceId, array $parameters = [])
    {
        return $this->_post("prices/{$priceId}", $parameters);
    }

    /**
     * Returns a list of all the prices.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('prices', $parameters);
    }
}
