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

class Invoices extends Api
{
    /**
     * Creates a new invoice.
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

        return $this->_post('invoices', $parameters);
    }

    /**
     * Retrieves an existing invoice.
     *
     * @param string $invoiceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $invoiceId): ApiResponse
    {
        return $this->_get("invoices/{$invoiceId}");
    }

    /**
     * Retrieves an existing invoice line items.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function lineItems(string $invoiceId, array $parameters = []): ApiResponse
    {
        return $this->_get("invoices/{$invoiceId}/lines", $parameters);
    }

    /**
     * Retrieves the given customer upcoming invoices.
     *
     * @param string $customerId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function upcomingInvoice(string $customerId, array $parameters = []): ApiResponse
    {
        $parameters = array_merge($parameters, [
            'customer' => $customerId,
        ]);

        return $this->_get('invoices/upcoming', $parameters);
    }

    /**
     * Updates an existing invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $invoiceId, array $parameters = []): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}", $parameters);
    }

    /**
     * Deletes the given draft invoice.
     *
     * @param string $invoiceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $invoiceId): ApiResponse
    {
        return $this->_delete("invoices/{$invoiceId}");
    }

    /**
     * Finalizes the given invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function finalize(string $invoiceId, array $parameters = []): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}/finalize", $parameters);
    }

    /**
     * Pays the given invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function pay(string $invoiceId, array $parameters = []): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}/pay", $parameters);
    }

    /**
     * Sends the given invoice.
     *
     * @param string $invoiceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function send(string $invoiceId): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}/send");
    }

    /**
     * Voids the given invoice.
     *
     * @param string $invoiceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function void(string $invoiceId): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}/void");
    }

    /**
     * Voids the given invoice.
     *
     * @param string $invoiceId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function markUncollectible(string $invoiceId): ApiResponse
    {
        return $this->_post("invoices/{$invoiceId}/mark_uncollectible");
    }

    /**
     * Lists all invoices.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('invoices', $parameters);
    }
}
