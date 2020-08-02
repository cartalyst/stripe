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

class TaxRates extends AbstractApi
{
    /**
     * Creates a new tax rate.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('tax_rates', $parameters);
    }

    /**
     * Retrieves an existing tax rate.
     *
     * @param string $taxRateId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $taxRateId): ApiResponse
    {
        return $this->_get("tax_rates/{$taxRateId}");
    }

    /**
     * Updates an existing tax rate.
     *
     * @param string $taxRateId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $taxRateId, array $parameters = []): ApiResponse
    {
        return $this->_post("tax_rates/{$taxRateId}", $parameters);
    }

    /**
     * Lists all tax rates.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('tax_rates', $parameters);
    }
}
