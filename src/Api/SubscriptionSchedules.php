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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class SubscriptionSchedules extends Api
{
    /**
     * Creates a new subscription schedule.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('subscription_schedules', $parameters);
    }

    /**
     * Retrieves an existing subscription schedule.
     *
     * @param  string  $itemId
     * @return array
     */
    public function find($itemId)
    {
        return $this->_get("subscription_schedules/{$itemId}");
    }

    /**
     * Updates an existing subscription schedule.
     *
     * @param  string  $itemId
     * @param  array  $parameters
     * @return array
     */
    public function update($itemId, array $parameters = [])
    {
        return $this->_post("subscription_schedules/{$itemId}", $parameters);
    }

    /**
     * Cancels an existing subscription schedule.
     *
     * @param  string  $itemId
     * @param  string  $parameters
     * @return array
     */
    public function cancel($itemId, array $parameters = [])
    {
        return $this->_post("subscription_schedules/{$itemId}/cancel", $parameters);
    }

    /**
     * Releases an existing subscription schedule.
     *
     * @param  string  $itemId
     * @param  string  $parameters
     * @return array
     */
    public function release($itemId, array $parameters = [])
    {
        return $this->_post("subscription_schedules/{$itemId}/release", $parameters);
    }

    /**
     * Lists all subscription schedules.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('subscription_schedules', $parameters);
    }
}
