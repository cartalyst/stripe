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

class Charges extends AbstractApi
{
    /**
     * Creates a new charge.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('v1/charges', $parameters);
    }

    /**
     * Retrieves an existing charge.
     *
     * @param  string  $id
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($id)
    {
        return $this->_get("v1/charges/{$id}");
    }

    /**
     * Updates an existing charge.
     *
     * @param  string  $id
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($id, array $parameters = [])
    {
        return $this->_post("v1/charges/{$id}", $parameters);
    }

    /**
     * Captures an existing charge.
     *
     * @param  string  $id
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function capture($id, array $parameters = [])
    {
        return $this->_post("v1/charges/{$id}/capture", $parameters);
    }

    /**
     * Lists all charges.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/charges', $parameters);
    }
}
