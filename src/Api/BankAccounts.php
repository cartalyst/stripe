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

class BankAccounts extends Api
{
    /**
     * Creates a new source on the given customer.
     *
     * @param  string  $customerId
     * @param  string|array  $parameters
     * @return array
     */
    public function create($customerId, $parameters = [])
    {
        if (is_array($parameters) && isset($parameters['source'])) {
            $parameters['source']['object'] = 'bank_account';
        } elseif (is_string($parameters)) {
            $parameters = ['source' => $parameters];
        }

        return $this->_post("customers/{$customerId}/sources", $parameters);
    }

    /**
     * Retrieves an existing source from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $sourceId
     * @return array
     */
    public function find($customerId, $sourceId)
    {
        return $this->_get("customers/{$customerId}/sources/{$sourceId}");
    }

    /**
     * Updates an existing source from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $sourceId
     * @param  array  $parameters
     * @return array
     */
    public function update($customerId, $sourceId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}/sources/{$sourceId}", $parameters);
    }

    /**
     * Deletes an existing source from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $sourceId
     * @return array
     */
    public function delete($customerId, $sourceId)
    {
        return $this->_delete("customers/{$customerId}/sources/{$sourceId}");
    }

    /**
     * Lists all sources from the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function all($customerId, array $parameters = [])
    {
        $parameters['object'] = 'bank_account';

        return $this->_get("customers/{$customerId}/sources", $parameters);
    }

    /**
     * Verifies the given bank account.
     *
     * @param  string  $customerId
     * @param  string  $bankAccountId
     * @param  array  $amounts
     * @param  string  $verificationMethod
     * @return array
     */
    public function verify($customerId, $bankAccountId, array $amounts, $verificationMethod = null)
    {
        return $this->_post("customers/{$customerId}/sources/{$bankAccountId}/verify", [
            'amounts' => $amounts, 'verification_method' => $verificationMethod,
        ]);
    }
}
