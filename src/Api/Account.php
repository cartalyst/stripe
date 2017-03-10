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
     * @param  string  $account
     * @return array
     */
    public function find($account)
    {
        return $this->_get("accounts/{$account}");
    }

    /**
     * Updates an existing account.
     *
     * @param  string  $account
     * @param  array  $parameters
     * @return array
     */
    public function update($account, array $parameters = [])
    {
        return $this->_post("accounts/{$account}", $parameters);
    }

    /**
     * Deletes an existing account.
     *
     * @param  string  $account
     * @return array
     */
    public function delete($account)
    {
        return $this->_delete("accounts/{$account}");
    }

    /**
     * Rejects an existing account.
     *
     * @param  string  $account
     * @param  string  $reason
     * @return array
     */
    public function reject($account, $reason)
    {
        return $this->_post("accounts/{$account}/reject", compact('reason'));
    }

    /**
     * Updates an existing account.
     *
     * @param  string  $account
     * @param  string  $file
     * @param  string  $purpose
     * @return array
     */
    public function verify($account, $file, $purpose)
    {
        $upload = (new FileUploads($this->config))->create(
            $file, $purpose, [ 'Stripe-Account' => $account ]
        );

        $this->update($account, [
            'legal_entity' => [
                'verification' => [
                    'document' => $upload['id'],
                ],
            ],
        ]);

        return $this->_get('accounts/'.$account);
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
}
