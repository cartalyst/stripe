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
 * @version    3.0.0
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
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function create($customer, array $parameters = [])
    {
        $parameters = array_merge($parameters, compact('customer'));

        return $this->_post('invoices', $parameters);
    }

    /**
     * Retrieves an existing invoice.
     *
     * @param  string  $invoice
     * @return array
     */
    public function find($invoice)
    {
        return $this->_get("invoices/{$invoice}");
    }

    /**
     * Retrieves an existing invoice line items.
     *
     * @param  string  $invoice
     * @param  array  $parameters
     * @return array
     */
    public function lineItems($invoice, array $parameters = [])
    {
        return $this->_get("invoices/{$invoice}/lines", $parameters);
    }

    /**
     * Retrieves the given customer upcoming invoices.
     *
     * @param  string  $customer
     * @param  string  $subscription
     * @param  array  $parameters
     * @return array
     */
    public function upcomingInvoice($customer, $subscription = null, array $parameters = [])
    {
        $parameters = array_merge($parameters, compact('customer', 'subscription'));

        return $this->_get('invoices/upcoming', $parameters);
    }

    /**
     * Updates an existing invoice.
     *
     * @param  string  $invoice
     * @param  array  $parameters
     * @return array
     */
    public function update($invoice, array $parameters = [])
    {
        return $this->_post("invoices/{$invoice}", $parameters);
    }

    /**
     * Pays the given invoice.
     *
     * @param  string  $invoice
     * @return array
     */
    public function pay($invoice)
    {
        return $this->_post("invoices/{$invoice}/pay");
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
