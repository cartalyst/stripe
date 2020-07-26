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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Plans extends Api
{
    /**
     * Creates a new plan.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('plans', $parameters);
    }

    /**
     * Retrieves an existing plan.
     *
     * @param  string  $planId
     * @return array
     */
    public function find($planId)
    {
        return $this->_get("plans/{$planId}");
    }

    /**
     * Updates an existing plan.
     *
     * @param  string  $planId
     * @param  array  $parameters
     * @return array
     */
    public function update($planId, array $parameters = [])
    {
        return $this->_post("plans/{$planId}", $parameters);
    }

    /**
     * Deletes an existing plan.
     *
     * @param  string  $planId
     * @return array
     */
    public function delete($planId)
    {
        return $this->_delete("plans/{$planId}");
    }

    /**
     * Lists all plans.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('plans', $parameters);
    }
}
