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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class TransferReversals extends AbstractApi
{
    /**
     * Creates a new transfer reversal.
     *
     * @param string $transferId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(string $transferId, array $parameters = []): ApiResponse
    {
        return $this->_post("transfers/{$transferId}/reversals", $parameters);
    }

    /**
     * Retrieves an existing transfer reversal.
     *
     * @param string $transferId
     * @param string $transferReversalId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $transferId, $transferReversalId): ApiResponse
    {
        return $this->_get("transfers/{$transferId}/reversals/{$transferReversalId}");
    }

    /**
     * Updates an existing transfer reversal.
     *
     * @param string $transferId
     * @param string $transferReversalId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $transferId, string $transferReversalId, array $parameters = []): ApiResponse
    {
        return $this->_post("transfers/{$transferId}/reversals/{$transferReversalId}", $parameters);
    }

    /**
     * Lists all transfer reversals.
     *
     * @param string $transferId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(string $transferId, array $parameters = []): ApiResponse
    {
        return $this->_get("transfers/{$transferId}/reversals", $parameters);
    }
}
