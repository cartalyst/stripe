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

class SubscriptionScheduleRevisions extends Api
{
    /**
     * Retrieves an existing subscription schedule revision.
     *
     * @param  string  $scheduleId
     * @param  string  $revisionId
     * @return array
     */
    public function find($scheduleId, $revisionId)
    {
        return $this->_get("subscription_schedules/{$scheduleId}/revisions/$revisionId");
    }

    /**
     * Lists all revisions of a subscription schedule.
     *
     * @param  string  $scheduleId
     * @param  array  $parameters
     * @return array
     */
    public function all($scheduleId, array $parameters = [])
    {
        return $this->_get("subscription_schedules/{$scheduleId}/revisions", $parameters);
    }
}
