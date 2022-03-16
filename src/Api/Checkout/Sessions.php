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

namespace Cartalyst\Stripe\Api\Checkout;

use Cartalyst\Stripe\Api\AbstractApi;
use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class Sessions extends AbstractApi
{
    /**
     * Creates a new session.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('checkout/sessions', $parameters);
    }

    /**
     * Retrieves an existing session.
     *
     * @param string $sessionId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $sessionId): ApiResponse
    {
        return $this->_get("checkout/sessions/{$sessionId}");
    }

    /**
     * Retrieves line items for an existing session.
     *
     * @param string $sessionId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function lineItems(string $sessionId): ApiResponse
    {
        return $this->_get("checkout/sessions/{$sessionId}/line_items");
    }
}
