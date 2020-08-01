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

class CustomerTaxIds extends Api
{
    /**
     * Creates a new customer tax id.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $customerId, array $parameters = []): ApiResponse
    {
        return $this->_post("customers/{$customerId}/tax_ids", $parameters);
    }

    /**
     * Retrieves an existing customer tax id.
     *
     * @param string $customerId
     * @param string $taxId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $customerId, $taxId): ApiResponse
    {
        return $this->_get("customers/{$customerId}/tax_ids/{$taxId}");
    }

    /**
     * Deletes an existing customer tax id.
     *
     * @param string $customerId
     * @param string $taxId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $customerId, $taxId): ApiResponse
    {
        return $this->_delete("customers/{$customerId}/tax_ids/{$taxId}");
    }

    /**
     * Lists all tax ids of the given customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(string $customerId, array $parameters = []): ApiResponse
    {
        return $this->_get("customers/{$customerId}/tax_ids", $parameters);
    }
}
