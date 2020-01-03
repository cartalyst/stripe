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
     * @param  array  $parameters
     * @return array
     */
    public function upcomingInvoice($customerId, $subscriptionId = null, array $parameters = [])
    {
        $parameters = array_merge($parameters, [
            'customer'     => $customerId,
            'subscription' => $subscriptionId,
        ]);

        return $this->_get('invoices/upcoming', $parameters);
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
     * Deletes the given draft invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function delete($invoiceId)
    {
        return $this->_delete("invoices/{$invoiceId}");
    }

    /**
     * Finalizes the given invoice.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return array
     */
    public function finalize($invoiceId, array $parameters = [])
    {
        return $this->_post("invoices/{$invoiceId}/finalize", $parameters);
    }

    /**
     * Pays the given invoice.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return array
     */
    public function pay($invoiceId, array $parameters = [])
    {
        return $this->_post("invoices/{$invoiceId}/pay", $parameters);
    }

    /**
     * Sends the given invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function send($invoiceId)
    {
        return $this->_post("invoices/{$invoiceId}/send");
    }

    /**
     * Voids the given invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function void($invoiceId)
    {
        return $this->_post("invoices/{$invoiceId}/void");
    }

    /**
     * Voids the given invoice.
     *
     * @param  string  $invoiceId
     * @return array
     */
    public function markUncollectible($invoiceId)
    {
        return $this->_post("invoices/{$invoiceId}/mark_uncollectible");
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
