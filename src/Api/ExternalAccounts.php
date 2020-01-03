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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class ExternalAccounts extends Api
{
    /**
     * Create a new bank account on a connected account.
     *
     * @param  string  $accountId
     * @param  string  $bankAccountId
     * @param  array  $parameters
     * @return array
     */
    public function create($accountId, array $parameters)
    {
        return $this->_post("accounts/{$accountId}/external_accounts", $parameters);
    }

    /**
     * Retrieves an existing bank account from a connected account.
     *
     * @param  string  $accountId
     * @param  string  $externalAccountId
     * @return array
     */
    public function find($accountId, $externalAccountId)
    {
        return $this->_get("accounts/{$accountId}/external_accounts/{$externalAccountId}");
    }

    /**
     * Updates an existing bank account on a connected account.
     *
     * @param  string  $accountId
     * @param  string  $externalAccountId
     * @param  array  $parameters
     * @return array
     */
    public function update($accountId, $externalAccountId, array $parameters = [])
    {
        return $this->_post("accounts/{$accountId}/external_accounts/{$externalAccountId}", $parameters);
    }

    /**
     * Deletes an existing bank account from a connected account.
     *
     * @param  string  $accountId
     * @param  string  $externalAccountId
     * @return array
     */
    public function delete($accountId, $externalAccountId)
    {
        return $this->_delete("accounts/{$accountId}/external_accounts/{$externalAccountId}");
    }

    /**
     * Returns a list of all the bank accounts from a connected account.
     *
     * @param  string  $accountId
     * @param  array  $parameters
     * @return array
     */
    public function all($accountId, array $parameters = [])
    {
        return $this->_get("accounts/{$accountId}/external_accounts", $parameters);
    }
}
