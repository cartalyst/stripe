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

class Plans extends AbstractApi
{
    /**
     * Creates a new plan.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters = [])
    {
        return $this->_post('v1/plans', $parameters);
    }

    /**
     * Retrieves an existing plan.
     *
     * @param  string  $id
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($id)
    {
        return $this->_get("v1/plans/{$id}");
    }

    /**
     * Updates an existing plan.
     *
     * @param  string  $id
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function update($id, array $parameters = [])
    {
        return $this->_post("v1/plans/{$id}", $parameters);
    }

    /**
     * Deletes an existing plan.
     *
     * @param  string  $id
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($id)
    {
        return $this->_delete("v1/plans/{$id}");
    }

    /**
     * Lists all plans.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('v1/plans', $parameters);
    }
}
