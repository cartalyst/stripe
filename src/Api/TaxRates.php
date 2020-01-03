<?php

/**
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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class TaxRates extends Api
{
    /**
     * Creates a new tax rate.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('tax_rates', $parameters);
    }

    /**
     * Retrieves an existing tax rate.
     *
     * @param  string  $taxRateId
     * @param  array  $parameters
     * @return array
     */
    public function find($taxRateId)
    {
        return $this->_get("tax_rates/{$taxRateId}");
    }

    /**
     * Updates an existing tax rate.
     *
     * @param  string  $taxRateId
     * @return array
     */
    public function update($taxRateId, array $parameters = [])
    {
        return $this->_post("tax_rates/{$taxRateId}", $parameters);
    }

    /**
     * Lists all tax rates.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('tax_rates', $parameters);
    }
}
