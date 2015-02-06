<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

use Cartalyst\Stripe\HttpClient;

class Refunds extends AbstractApi
{
    /**
     * Creates a new refund for the given charge.
     *
     * @param  string  $chargeId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create($chargeId, array $parameters = [])
    {
        return $this->_post("v1/charges/{$chargeId}/refunds", [ 'query' => $parameters ]);
    }

    /**
     * Retrieves an existing refund from the given charge.
     *
     * @param  string  $chargeId
     * @param  string  $refundId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($chargeId)
    {
        return $this->_get("v1/charges/{$chargeId}/refunds/{$refundId}");
    }

    /**
     * Updates an existing refund on the given charge.
     *
     * @param  string  $chargeId
     * @param  array  $parameters
     * @param  string  $refundId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($chargeId, $refundId, array $parameters = [])
    {
        return $this->_post("v1/charges/{$chargeId}/refunds/{$refundId}", [ 'query' => $parameters ]);
    }

    /**
     * Lists all refunds for the given charge.
     *
     * @param  string  $chargeId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all($chargeId, array $parameters = [])
    {
        return $this->_get("v1/charges/{$chargeId}/refunds", [ 'query' => $parameters ]);
    }
}
