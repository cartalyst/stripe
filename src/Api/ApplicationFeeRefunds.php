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

class ApplicationFeeRefunds extends Api
{
    /**
     * Creates a new application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create($applicationFeeId, array $parameters = [])
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds", $parameters);
    }

    /**
     * Retrieves an existing application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  string  $refundId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($applicationFeeId, $refundId)
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds/{$refundId}");
    }

    /**
     * Updates an existing application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  string  $refundId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($applicationFeeId, $refundId, array $parameters = [])
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all application fee refunds.
     *
     * @param  string  $applicationFeeId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all($applicationFeeId, array $parameters = [])
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds", $parameters);
    }
}
