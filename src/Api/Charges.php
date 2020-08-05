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

class Charges extends AbstractApi
{
    /**
     * Creates a new charge.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('charges', $parameters);
    }

    /**
     * Retrieves an existing charge.
     *
     * @param string $chargeId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $chargeId): ApiResponse
    {
        return $this->_get("charges/{$chargeId}");
    }

    /**
     * Updates an existing charge.
     *
     * @param string $chargeId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function update(string $chargeId, array $parameters = []): ApiResponse
    {
        return $this->_post("charges/{$chargeId}", $parameters);
    }

    /**
     * Captures an existing charge.
     *
     * @param string $chargeId
     * @param int    $amount
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    // TODO: Either remove or add a fullCapture and partialCapture to avoid nullables in between
    public function capture(string $chargeId, ?int $amount = null, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, array_filter([
            'amount' => $amount,
        ]));

        return $this->_post("charges/{$chargeId}/capture", $parameters);
    }

    /**
     * Lists all charges.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('charges', $parameters);
    }
}
