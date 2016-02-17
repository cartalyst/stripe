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
 * @version    1.0.8
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Cards extends Api
{
    /**
     * Creates a new card on the given customer.
     *
     * @param  string  $customerId
     * @param  string|array  $parameters
     * @return array
     */
    public function create($customerId, $parameters = [])
    {
        if (is_array($parameters)) {
            $parameters['object'] = 'card';
        }

        $parameters = [ 'source' => $parameters ];

        return $this->_post("customers/{$customerId}/sources", $parameters);
    }

    /**
     * Retrieves an existing card from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $cardId
     * @return array
     */
    public function find($customerId, $cardId)
    {
        return $this->_get("customers/{$customerId}/sources/{$cardId}");
    }

    /**
     * Updates an existing card from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $cardId
     * @param  array  $parameters
     * @return array
     */
    public function update($customerId, $cardId, array $parameters = [])
    {
        return $this->_post("customers/{$customerId}/sources/{$cardId}", $parameters);
    }

    /**
     * Deletes an existing card from the given customer.
     *
     * @param  string  $customerId
     * @param  string  $cardId
     * @return array
     */
    public function delete($customerId, $cardId)
    {
        return $this->_delete("customers/{$customerId}/sources/{$cardId}");
    }

    /**
     * Lists all cards from the given customer.
     *
     * @param  string  $customerId
     * @param  array  $parameters
     * @return array
     */
    public function all($customerId, array $parameters = [])
    {
        return $this->_get("customers/{$customerId}/sources", $parameters);
    }
}
