<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Invoices extends Api
{
    /**
     * Creates a new invoice.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('v1/invoices', $parameters);
    }

    /**
     * Retrieves an existing invoice.
     *
     * @param  string  $invoiceId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($invoiceId)
    {
        return $this->_get("v1/invoices/{$invoiceId}");
    }

    /**
     * Retrieves an existing invoice line items.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function lineItems($invoiceId, array $parameters = [])
    {
        return $this->_get("v1/invoices/{$invoiceId}/lines", $parameters);
    }

    /**
     * Retrieves the given customer upcoming invoices.
     *
     * @param  string  $customerId
     * @param  string  $subscriptionId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function upcomingInvoice($customerId, $subscriptionId = null)
    {
        return $this->_get('v1/invoices/upcoming', [
            'customer'     => $customerId,
            'subscription' => $subscriptionId,
        ]);
    }

    /**
     * Updates an existing invoice.
     *
     * @param  string  $invoiceId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($invoiceId, array $parameters = [])
    {
        return $this->_post("v1/invoices/{$invoiceId}", $parameters);
    }

    /**
     * Pays the given invoice.
     *
     * @param  string  $invoiceId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function pay($invoiceId)
    {
        return $this->_post("v1/invoices/{$invoiceId}/pay");
    }

    /**
     * Lists all invoices.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/invoices', $parameters);
    }
}
