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

class Disputes extends Api
{
    /**
     * Retrieves an existing dispute.
     *
     * @param string $disputeId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $disputeId): ApiResponse
    {
        return $this->_get("disputes/{$disputeId}");
    }

    /**
     * Updates an existing dispute.
     *
     * @param string $disputeId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $disputeId, array $parameters = []): ApiResponse
    {
        return $this->_post("disputes/{$disputeId}", $parameters);
    }

    /**
     * Closes an existing dispute.
     *
     * @param string $disputeId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function close(string $disputeId): ApiResponse
    {
        return $this->_post("disputes/{$disputeId}/close");
    }

    /**
     * Lists all disputes.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('disputes', $parameters);
    }
}
