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

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\AbstractApi;
use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class EarlyFraudWarning extends AbstractApi
{
    /**
     * Retrieves an existing early fraud warning.
     *
     * @param string $earlyFraudWarningId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $earlyFraudWarningId): ApiResponse
    {
        return $this->_get("radar/early_fraud_warnings/{$earlyFraudWarningId}");
    }

    /**
     * Lists all early fraud warnings.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('radar/early_fraud_warnings', $parameters);
    }
}
