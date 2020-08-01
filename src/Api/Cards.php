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

class Cards extends Api
{
    /**
     * Creates a new source on the given customer.
     *
     * @param string       $customerId
     * @param array|string $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $customerId, $parameters = []): ApiResponse
    {
        if (is_array($parameters) && isset($parameters['source'])) {
            $parameters['source']['object'] = 'card';
        } elseif (is_string($parameters)) {
            $parameters = ['source' => $parameters];
        }

        return $this->_post("customers/{$customerId}/sources", $parameters);
    }

    /**
     * Retrieves an existing source from the given customer.
     *
     * @param string $customerId
     * @param string $sourceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $customerId, string $sourceId): ApiResponse
    {
        return $this->_get("customers/{$customerId}/sources/{$sourceId}");
    }

    /**
     * Updates an existing source from the given customer.
     *
     * @param string $customerId
     * @param string $sourceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $customerId, string $sourceId, array $parameters = []): ApiResponse
    {
        return $this->_post("customers/{$customerId}/sources/{$sourceId}", $parameters);
    }

    /**
     * Deletes an existing source from the given customer.
     *
     * @param string $customerId
     * @param string $sourceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $customerId, string $sourceId): ApiResponse
    {
        return $this->_delete("customers/{$customerId}/sources/{$sourceId}");
    }

    /**
     * Lists all sources from the given customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $customerId, array $parameters = []): ApiResponse
    {
        $parameters['object'] = 'card';

        return $this->_get("customers/{$customerId}/sources", $parameters);
    }
}
