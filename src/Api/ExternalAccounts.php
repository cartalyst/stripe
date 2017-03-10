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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class ExternalAccounts extends Api
{
    /**
     * Create a new bank account or debit card on a connected account.
     *
     * @param  string  $account
     * @param  array  $parameters
     * @return array
     */
    public function create($account, array $parameters)
    {
        return $this->_post("accounts/{$account}/external_accounts", $parameters);
    }

    /**
     * Retrieves an existing bank account or debit card from a connected account.
     *
     * @param  string  $account
     * @param  string  $object
     * @return array
     */
    public function find($account, $object)
    {
        return $this->_get("accounts/{$account}/external_accounts/{$object}");
    }

    /**
     * Updates an existing bank account or debit card on a connected account.
     *
     * @param  string  $account
     * @param  string  $object
     * @param  array  $parameters
     * @return array
     */
    public function update($account, $object, array $parameters = [])
    {
        return $this->_post("accounts/{$account}/external_accounts/{$object}", $parameters);
    }

    /**
     * Deletes an existing bank account or debit card from a connected account.
     *
     * @param  string  $account
     * @param  string  $object
     * @return array
     */
    public function delete($account, $object)
    {
        return $this->_delete("accounts/{$account}/external_accounts/{$object}");
    }

    /**
     * Returns a list of all the bank accounts or debit cards from a connected account.
     *
     * @param  string  $account
     * @param  array  $parameters
     * @return array
     */
    public function all($account, array $parameters = [])
    {
        return $this->_get("accounts/{$account}/external_accounts", $parameters);
    }
}
