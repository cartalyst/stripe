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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class CustomerTaxIds extends Api
{
    /**
     * Creates a new customer tax id.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function create($customerId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}/tax_ids", $parameters);
    }

    /**
     * Retrieves an existing customer tax id.
     *
     * @param  string  $customerId
     * @param  string  $taxId
     * @return array
     */
    public function find($customerId, $taxId)
    {
        return $this->_get("customers/{$customerId}/tax_ids/{$taxId}");
    }

    /**
     * Deletes an existing customer tax id.
     *
     * @param  string  $customerId
     * @param  string  $taxId
     * @return array
     */
    public function delete($customerId, $taxId)
    {
        return $this->_delete("customers/{$customerId}/tax_ids/{$taxId}");
    }

    /**
     * Lists all tax ids of the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function all($customerId, array $parameters = [])
    {
        return $this->_get("customers/{$customerId}/tax_ids", $parameters);
    }
}
