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
 * @version    1.0.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class InvoiceItems extends Api
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
