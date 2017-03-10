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

class InvoiceItems extends Api
{
    /**
     * Creates a new invoice item on the given customer
     *
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function create($customer, array $parameters = [])
    {
        $parameters = array_merge($parameters, compact('customer'));

        return $this->_post('invoiceitems', $parameters);
    }

    /**
     * Retrieves an existing invoice item.
     *
     * @param  string  $item
     * @return array
     */
    public function find($item)
    {
        return $this->_get("invoiceitems/{$item}");
    }

    /**
     * Updates an existing invoice item.
     *
     * @param  string  $item
     * @param  array  $parameters
     * @return array
     */
    public function update($item, array $parameters = [])
    {
        return $this->_post("invoiceitems/{$item}", $parameters);
    }

    /**
     * Deletes an existing invoice item.
     *
     * @param  string  $item
     * @return array
     */
    public function delete($item)
    {
        return $this->_delete("invoiceitems/{$item}");
    }

    /**
     * Lists all invoice items.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('invoiceitems', $parameters);
    }
}
