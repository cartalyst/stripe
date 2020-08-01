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

use Cartalyst\Stripe\Api\Account\Persons;
use Cartalyst\Stripe\Api\Account\AccountLink;
use Cartalyst\Stripe\Api\Account\Capabilities;

class Account extends Api
{
    /**
     * Retrieves the details of the account, based on the
     * API key that was used to make the request.
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function details(): ApiResponse
    {
        return $this->_get('account');
    }

    /**
     * Creates a new account.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('accounts', $parameters);
    }

    /**
     * Retrieves an existing account.
     *
     * @param string $accountId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $accountId): ApiResponse
    {
        return $this->_get("accounts/{$accountId}");
    }

    /**
     * Updates an existing account.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $accountId, array $parameters = []): ApiResponse
    {
        return $this->_post("accounts/{$accountId}", $parameters);
    }

    /**
     * Deletes an existing account.
     *
     * @param string $accountId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $accountId): ApiResponse
    {
        return $this->_delete("accounts/{$accountId}");
    }

    /**
     * Rejects an existing account.
     *
     * @param string $accountId
     * @param string $reason
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function reject(string $accountId, string $reason): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/reject", [
            'reason' => $reason,
        ]);
    }

    /**
     * Returns a list of all the connected accounts.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('accounts', $parameters);
    }

    /**
     * Creates a login link.
     *
     * @param string      $accountId
     * @param string|null $redirectUrl
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function createLoginLink(string $accountId, ?string $redirectUrl = null): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/login_links", [
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * Returns an account links api instance.
     *
     * @return \Cartalyst\Stripe\Api\Account\AccountLink
     */
    public function accountLinks(): AccountLink
    {
        return new AccountLink($this->config);
    }

    /**
     * Returns an account capabilities api instance.
     *
     * @return \Cartalyst\Stripe\Api\Account\Capabilities
     */
    public function capabilities(): Capabilities
    {
        return new Capabilities($this->config);
    }

    /**
     * Returns an account persons api instance.
     *
     * @return \Cartalyst\Stripe\Api\Account\Persons
     */
    public function persons(): Persons
    {
        return new Persons($this->config);
    }
}
