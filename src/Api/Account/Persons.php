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

namespace Cartalyst\Stripe\Api\Account;

use Cartalyst\Stripe\Api\AbstractApi;
use Cartalyst\Stripe\Api\ApiResponse;

class Persons extends AbstractApi
{
    /**
     * Creates a new person.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $accountId, array $parameters = []): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/persons", $parameters);
    }

    /**
     * Retrieves an existing person.
     *
     * @param string $accountId
     * @param string $personId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $accountId, string $personId): ApiResponse
    {
        return $this->_get("accounts/{$accountId}/persons/{$personId}");
    }

    /**
     * Updates an existing person.
     *
     * @param string $accountId
     * @param string $personId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $accountId, string $personId, array $parameters = []): ApiResponse
    {
        return $this->_post("accounts/{$accountId}/persons/{$personId}", $parameters);
    }

    /**
     * Deletes an existing person.
     *
     * @param string $accountId
     * @param string $personId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $accountId, string $personId): ApiResponse
    {
        return $this->_delete("accounts/{$accountId}/persons/{$personId}");
    }

    /**
     * Lists all persons of the given account.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $accountId, array $parameters = []): ApiResponse
    {
        return $this->_get("accounts/{$accountId}/persons", $parameters);
    }
}
