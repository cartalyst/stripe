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

class ExternalAccounts extends Api
{
    /**
     * Create a new bank account on a connected account.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $accountId, array $parameters): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/external_accounts", $parameters);
    }

    /**
     * Retrieves an existing bank account from a connected account.
     *
     * @param string $accountId
     * @param string $externalAccountId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $accountId, string $externalAccountId): ApiResponse
    {
        return $this->_get("accounts/{$accountId}/external_accounts/{$externalAccountId}");
    }

    /**
     * Updates an existing bank account on a connected account.
     *
     * @param string $accountId
     * @param string $externalAccountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $accountId, string $externalAccountId, array $parameters = []): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/external_accounts/{$externalAccountId}", $parameters);
    }

    /**
     * Deletes an existing bank account from a connected account.
     *
     * @param string $accountId
     * @param string $externalAccountId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $accountId, string $externalAccountId): ApiResponse
    {
        return $this->_delete("accounts/{$accountId}/external_accounts/{$externalAccountId}");
    }

    /**
     * Returns a list of all the bank accounts from a connected account.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $accountId, array $parameters = []): ApiResponse
    {
        return $this->_get("accounts/{$accountId}/external_accounts", $parameters);
    }
}
