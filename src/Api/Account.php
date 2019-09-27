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

class Account extends Api
{
    /**
     * Retrieves the details of the account, based on the
     * API key that was used to make the request.
     *
     * @return array
     */
    public function details()
    {
        return $this->_get('account');
    }

    /**
     * Creates a new account.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('accounts', $parameters);
    }

    /**
     * Retrieves an existing account.
     *
     * @param  string  $accountId
     * @return array
     */
    public function find($accountId)
    {
        return $this->_get("accounts/{$accountId}");
    }

    /**
     * Updates an existing account.
     *
     * @param  string  $accountId
     * @param  array  $parameters
     * @return array
     */
    public function update($accountId, array $parameters = [])
    {
        return $this->_post("accounts/{$accountId}", $parameters);
    }

    /**
     * Deletes an existing account.
     *
     * @param  string  $accountId
     * @return array
     */
    public function delete($accountId)
    {
        return $this->_delete("accounts/{$accountId}");
    }

    /**
     * Rejects an existing account.
     *
     * @param  string  $accountId
     * @param  string  $reason
     * @return array
     */
    public function reject($accountId, $reason)
    {
        return $this->_post("accounts/{$accountId}/reject", compact('reason'));
    }

    /**
     * Updates an existing account.
     *
     * @param  string  $accountId
     * @param  string  $file
     * @param  array  $parameters
     * @return array
     */
    public function verify($accountId, $file, $purpose)
    {
        $upload = (new FileUploads($this->config))->create(
            $file, $purpose, [ 'Stripe-Account' => $accountId ]
        );

        $this->update($accountId, [
            'legal_entity' => [
                'verification' => [
                    'document' => $upload['id'],
                ],
            ],
        ]);

        return $this->_get('accounts/'.$accountId);
    }

    /**
     * Returns a list of all the connected accounts.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('accounts', $parameters);
    }

    /**
     * Creates a login link.
     *
     * @param  string  $accountId
     * @param  string|null  $redirectUrl
     * @return array
     */
    public function createLoginLink($accountId, $redirectUrl = null)
    {
        return $this->_post("accounts/{$accountId}/login_links", [
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * Returns an account persons api instance.
     *
     * @return \Cartalyst\Stripe\Api\Account\Persons
     */
    public function persons()
    {
        return new Account\Persons($this->config);
    }
}
