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

class Refunds extends AbstractApi
{
    /**
     * Creates a new refund for the given charge.
     *
     * @param string $chargeId
     * @param int    $amount
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create($chargeId, $amount = null, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, array_filter([
            'charge' => $chargeId,
            'amount' => $amount,
        ]));

        return $this->_post('refunds', $parameters);
    }

    /**
     * Retrieves an existing refund from the given charge.
     *
     * @param string $refundId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $refundId): ApiResponse
    {
        return $this->_get("refunds/{$refundId}");
    }

    /**
     * Updates an existing refund on the given charge.
     *
     * @param string $refundId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $refundId, array $parameters = []): ApiResponse
    {
        return $this->_post("refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all the refunds of the current Stripe account
     * or lists all the refunds for the given charge.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('refunds', $parameters);
    }
}
