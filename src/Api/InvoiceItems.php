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
     * Creates a new invoice item on the given customer
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create($customerId, array $parameters = [])
    {
        $parameters = array_merge($parameters, [
            'customer' => $customerId,
        ]);
        return $this->_post('invoiceitems', $parameters);
    }

    /**
     * Retrieves an existing invoice item.
     *
     * @param  string  $invoiceItemId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($invoiceItemId)
    {
        return $this->_get("invoiceitems/{$invoiceItemId}");
    }

    /**
     * Updates an existing invoice item.
     *
     * @param  string  $invoiceItemId
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($invoiceItemId, array $parameters = [])
    {
        return $this->_post("invoiceitems/{$invoiceItemId}", $parameters);
    }

    /**
     * Deletes an existing invoice item.
     *
     * @param  string  $invoiceItemId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($invoiceItemId)
    {
        return $this->_delete("invoiceitems/{$invoiceItemId}");
    }

    /**
     * Lists all invoice items.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('invoiceitems', $parameters);
    }
}
