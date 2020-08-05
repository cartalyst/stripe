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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class Sources extends AbstractApi
{
    /**
     * Creates a new source on the given customer.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('sources', $parameters);
    }

    /**
     * Retrieves an existing source.
     *
     * @param string $sourceId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $sourceId): ApiResponse
    {
        return $this->_get("sources/{$sourceId}");
    }

    /**
     * Updates an existing source.
     *
     * @param string $sourceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $sourceId, array $parameters = []): ApiResponse
    {
        return $this->_post("sources/{$sourceId}", $parameters);
    }

    /**
     * Attaches the given source to the customer.
     *
     * @param string $customerId
     * @param string $sourceId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function attach(string $customerId, string $sourceId): ApiResponse
    {
        return $this->_post("customers/{$customerId}/sources", [
            'source' => $sourceId,
        ]);
    }

    /**
     * Detaches the given source from the customer.
     *
     * @param string $customerId
     * @param string $sourceId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function detach(string $customerId, string $sourceId): ApiResponse
    {
        return $this->_delete("customers/{$customerId}/sources/{$sourceId}");
    }
}
