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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\Api;

class ValueLists extends Api
{
    /**
     * Creates a new radar value list.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('radar/value_lists', $parameters);
    }

    /**
     * Retrieves an existing radar value list.
     *
     * @param  string  $valueListId
     * @return array
     */
    public function find($valueListId)
    {
        return $this->_get("radar/value_lists/{$valueListId}");
    }

    /**
     * Updates an existing radar value list.
     *
     * @param  string  $valueListId
     * @param  array  $parameters
     * @return array
     */
    public function update($valueListId, array $parameters = [])
    {
        return $this->_post("radar/value_lists/{$valueListId}", $parameters);
    }

    /**
     * Deletes an existing radar value list.
     *
     * @param  string  $valueListId
     * @return array
     */
    public function delete($valueListId)
    {
        return $this->_delete("radar/value_lists/{$valueListId}");
    }

    /**
     * Lists all radar value lists.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('radar/value_lists', $parameters);
    }
}
