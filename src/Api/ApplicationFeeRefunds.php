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

class ApplicationFeeRefunds extends Api
{
    /**
     * Creates a new application fee refund.
     *
     * @param string $applicationFeeId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $applicationFeeId, array $parameters = []): ApiResponse
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds", $parameters);
    }

    /**
     * Retrieves an existing application fee refund.
     *
     * @param string $applicationFeeId
     * @param string $refundId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $applicationFeeId, string $refundId): ApiResponse
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds/{$refundId}");
    }

    /**
     * Updates an existing application fee refund.
     *
     * @param string $applicationFeeId
     * @param string $refundId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $applicationFeeId, string $refundId, array $parameters = []): ApiResponse
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all application fee refunds.
     *
     * @param string $applicationFeeId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $applicationFeeId, array $parameters = []): ApiResponse
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds", $parameters);
    }
}
