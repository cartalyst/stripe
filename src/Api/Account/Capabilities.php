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
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api\Account;

use Cartalyst\Stripe\Api\Api;

class Capabilities extends Api
{
    /**
     * Retrieves an existing capability.
     *
     * @param  string  $accountId
     * @param  string  $capabilityId
     * @return array
     */
    public function find($accountId, $capabilityId)
    {
        return $this->_get("accounts/{$accountId}/capabilities/{$capabilityId}");
    }

    /**
     * Updates an existing capability.
     *
     * @param  string  $accountId
     * @param  string  $capabilityId
     * @param  array  $parameters
     * @return array
     */
    public function update($accountId, $capabilityId, array $parameters = [])
    {
        return $this->_post("accounts/{$accountId}/capabilities/{$capabilityId}", $parameters);
    }

    /**
     * Lists all capabilities.
     *
     * @param  string  $accountId
     * @param  array  $parameters
     * @return array
     */
    public function all($accountId, array $parameters = [])
    {
        return $this->_get("accounts/{$accountId}/capabilities", $parameters);
    }
}
