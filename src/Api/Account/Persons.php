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

namespace Cartalyst\Stripe\Api\Account;

use Cartalyst\Stripe\Api\Api;

class Persons extends Api
{
    /**
     * Creates a new person.
     *
     * @param  string  $accountId
     * @param  array  $parameters
     * @return array
     */
    public function create($accountId, array $parameters = [])
    {
        return $this->_post("accounts/{$accountId}/persons", $parameters);
    }

    /**
     * Retrieves an existing person.
     *
     * @param  string  $accountId
     * @param  string  $personId
     * @return array
     */
    public function find($accountId, $personId)
    {
        return $this->_get("accounts/{$accountId}/persons/{$personId}");
    }

    /**
     * Updates an existing coupon.
     *
     * @param  string  $accountId
     * @param  string  $personId
     * @param  array  $parameters
     * @return array
     */
    public function update($accountId, $personId, array $parameters = [])
    {
        return $this->_post("accounts/{$accountId}/persons/{$personId}", $parameters);
    }

    /**
     * Deletes an existing coupon.
     *
     * @param  string  $accountId
     * @param  string  $personId
     * @return array
     */
    public function delete($accountId, $personId)
    {
        return $this->_delete("accounts/{$accountId}/persons/{$personId}");
    }

    /**
     * Lists all persons.
     *
     * @param  string  $accountId
     * @param  array  $parameters
     * @return array
     */
    public function all($accountId, array $parameters = [])
    {
        return $this->_get("accounts/{$accountId}/persons", $parameters);
    }
}
