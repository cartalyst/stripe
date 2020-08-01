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

class Topup extends Api
{
    /**
     * Creates a new top-up.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('topups', $parameters);
    }

    /**
     * Retrieves an existing top-up.
     *
     * @param string $topupId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $topupId): ApiResponse
    {
        return $this->_get("topups/{$topupId}");
    }

    /**
     * Updates an existing top-up.
     *
     * @param string $topupId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $topupId, array $parameters = []): ApiResponse
    {
        return $this->_post("topups/{$topupId}", $parameters);
    }

    /**
     * Cancels an existing top-up.
     *
     * @param string $topupId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function cancel(string $topupId): ApiResponse
    {
        return $this->_post("topups/{$topupId}/cancel");
    }

    /**
     * Deletes an existing top-up.
     *
     * @param string $topupId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $topupId): ApiResponse
    {
        return $this->_delete("topups/{$topupId}");
    }

    /**
     * Lists all top-ups.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('topups', $parameters);
    }
}
