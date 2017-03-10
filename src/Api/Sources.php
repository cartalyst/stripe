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

class Sources extends Api
{
    /**
     * Creates a new source on the given customer.
     *
     * @param  string  $customer
     * @param  string|array  $parameters
     * @return array
     */
    public function create($customer, $parameters = [])
    {
        if (is_array($parameters)) {
            $parameters['object'] = $this->sourceType;
        }

        $parameters = [ 'source' => $parameters ];

        return $this->_post("customers/{$customer}/sources", $parameters);
    }

    /**
     * Retrieves an existing source from the given customer.
     *
     * @param  string  $customer
     * @param  string  $source
     * @return array
     */
    public function find($customer, $source)
    {
        return $this->_get("customers/{$customer}/sources/{$source}");
    }

    /**
     * Updates an existing source from the given customer.
     *
     * @param  string  $customer
     * @param  string  $source
     * @param  array  $parameters
     * @return array
     */
    public function update($customer, $source, array $parameters = [])
    {
        return $this->_post("customers/{$customer}/sources/{$source}", $parameters);
    }

    /**
     * Deletes an existing source from the given customer.
     *
     * @param  string  $customer
     * @param  string  $source
     * @return array
     */
    public function delete($customer, $source)
    {
        return $this->_delete("customers/{$customer}/sources/{$source}");
    }

    /**
     * Lists all sources from the given customer.
     *
     * @param  string  $customer
     * @param  array  $parameters
     * @return array
     */
    public function all($customer, array $parameters = [])
    {
        return $this->_get("customers/{$customer}/sources", $parameters);
    }
}
