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

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\Api;
use Cartalyst\Stripe\Api\ApiResponse;

class ValueListItems extends Api
{
    /**
     * Creates a new radar value list item.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('radar/value_list_items', $parameters);
    }

    /**
     * Retrieves an existing radar value list item.
     *
     * @param string $valueListItemId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $valueListItemId): ApiResponse
    {
        return $this->_get("radar/value_list_items/{$valueListItemId}");
    }

    /**
     * Deletes an existing radar value list item.
     *
     * @param string $valueListItemId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $valueListItemId): ApiResponse
    {
        return $this->_delete("radar/value_list_items/{$valueListItemId}");
    }

    /**
     * Lists all radar value list items.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('radar/value_list_items', $parameters);
    }
}
