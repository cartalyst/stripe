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
 * @version    2.0.8
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Invoices extends Api
{
    /**
     * Creates a new invoice.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function create($customerId, array $parameters = [])
    {
        $parameters = array_merge($parameters, [
            'customer' => $customerId,
        ]);

        return $this->_post('invoices', $parameters);
    }

    /**
     * Retrieves an existing invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function find($invoiceId)
    {
        return $this->_get("invoices/{$invoiceId}");
    }

    /**
     * Retrieves an existing invoice line items.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return array
     */
    public function lineItems($invoiceId, array $parameters = [])
    {
        return $this->_get("invoices/{$invoiceId}/lines", $parameters);
    }

    /**
     * Retrieves the given customer upcoming invoices.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return array
     */
    public function upcomingInvoice($customerId, $subscriptionId = null)
    {
        return $this->_get('invoices/upcoming', [
            'customer'     => $customerId,
            'subscription' => $subscriptionId,
        ]);
    }

    /**
     * Updates an existing invoice.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return array
     */
    public function update($invoiceId, array $parameters = [])
    {
        return $this->_post("invoices/{$invoiceId}", $parameters);
    }

    /**
     * Pays the given invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function pay($invoiceId)
    {
        return $this->_post("invoices/{$invoiceId}/pay");
    }

    /**
     * Lists all invoices.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('invoices', $parameters);
    }
}
