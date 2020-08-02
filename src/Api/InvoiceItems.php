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

class InvoiceItems extends AbstractApi
{
    /**
     * Creates a new invoice item on the given customer.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $customerId, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, [
            'customer' => $customerId,
        ]);

        return $this->_post('invoiceitems', $parameters);
    }

    /**
     * Retrieves an existing invoice item.
     *
     * @param string $invoiceItemId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $invoiceItemId): ApiResponse
    {
        return $this->_get("invoiceitems/{$invoiceItemId}");
    }

    /**
     * Updates an existing invoice item.
     *
     * @param string $invoiceItemId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $invoiceItemId, array $parameters = []): ApiResponse
    {
        return $this->_post("invoiceitems/{$invoiceItemId}", $parameters);
    }

    /**
     * Deletes an existing invoice item.
     *
     * @param string $invoiceItemId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $invoiceItemId): ApiResponse
    {
        return $this->_delete("invoiceitems/{$invoiceItemId}");
    }

    /**
     * Lists all invoice items.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('invoiceitems', $parameters);
    }
}
