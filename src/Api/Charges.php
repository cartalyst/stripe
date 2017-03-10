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

class Charges extends Api
{
    /**
     * Creates a new charge.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('charges', $parameters);
    }

    /**
     * Retrieves an existing charge.
     *
     * @param  string  $charge
     * @return array
     */
    public function find($charge)
    {
        return $this->_get("charges/{$charge}");
    }

    /**
     * Updates an existing charge.
     *
     * @param  string  $charge
     * @param  array  $parameters
     * @return array
     */
    public function update($charge, array $parameters = [])
    {
        return $this->_post("charges/{$charge}", $parameters);
    }

    /**
     * Captures an existing charge.
     *
     * @param  string  $charge
     * @param  int  $amount
     * @param  array  $parameters
     * @return array
     */
    public function capture($charge, $amount = null, array $parameters = [])
    {
        $parameters = array_merge($parameters, array_filter(compact('amount')));

        return $this->_post("charges/{$charge}/capture", $parameters);
    }

    /**
     * Lists all charges.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('charges', $parameters);
    }
}
