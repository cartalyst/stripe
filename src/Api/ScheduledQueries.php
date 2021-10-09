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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class ScheduledQueries extends Api
{
    /**
     * Retrieves an existing scheduled query.
     *
     * @param  string  $scheduleQueryRun
     * @return array
     */
    public function find($scheduleQueryRun)
    {
        return $this->_get("sigma/scheduled_query_runs/{$scheduleQueryRun}");
    }

    /**
     * Returns a list of all the scheduled queries.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('sigma/scheduled_query_runs', $parameters);
    }
}
