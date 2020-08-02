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

class Payouts extends AbstractApi
{
    /**
     * Creates a new payout.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('payouts', $parameters);
    }

    /**
     * Retrieves an existing payout.
     *
     * @param string $payoutId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $payoutId): ApiResponse
    {
        return $this->_get("payouts/{$payoutId}");
    }

    /**
     * Updates an existing payout.
     *
     * @param string $payoutId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $payoutId, array $parameters = []): ApiResponse
    {
        return $this->_post("payouts/{$payoutId}", $parameters);
    }

    /**
     * Cancels the given payout.
     *
     * @param string $payoutId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function cancel(string $payoutId): ApiResponse
    {
        return $this->_post("payouts/{$payoutId}/cancel");
    }

    /**
     * Lists all payouts.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('payouts', $parameters);
    }
}
