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

class SubscriptionSchedules extends AbstractApi
{
    /**
     * Creates a new subscription schedule.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('subscription_schedules', $parameters);
    }

    /**
     * Retrieves an existing subscription schedule.
     *
     * @param string $itemId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $itemId): ApiResponse
    {
        return $this->_get("subscription_schedules/{$itemId}");
    }

    /**
     * Updates an existing subscription schedule.
     *
     * @param string $itemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $itemId, array $parameters = []): ApiResponse
    {
        return $this->_post("subscription_schedules/{$itemId}", $parameters);
    }

    /**
     * Cancels an existing subscription schedule.
     *
     * @param string $itemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function cancel(string $itemId, array $parameters = []): ApiResponse
    {
        return $this->_post("subscription_schedules/{$itemId}/cancel", $parameters);
    }

    /**
     * Releases an existing subscription schedule.
     *
     * @param string $itemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function release(string $itemId, array $parameters = []): ApiResponse
    {
        return $this->_post("subscription_schedules/{$itemId}/release", $parameters);
    }

    /**
     * Lists all subscription schedules.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('subscription_schedules', $parameters);
    }
}
