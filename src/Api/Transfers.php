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

class Transfers extends AbstractApi
{
    /**
     * Creates a new transfer.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('transfers', $parameters);
    }

    /**
     * Retrieves an existing transfer.
     *
     * @param string $transferId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $transferId): ApiResponse
    {
        return $this->_get("transfers/{$transferId}");
    }

    /**
     * Updates an existing transfer.
     *
     * @param string $transferId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $transferId, array $parameters = []): ApiResponse
    {
        return $this->_post("transfers/{$transferId}", $parameters);
    }

    /**
     * Lists all transfers.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('transfers', $parameters);
    }
}
