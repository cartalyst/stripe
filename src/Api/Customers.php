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

use Cartalyst\Stripe\HttpClient;

class Customers extends AbstractApi
{
    public function create(array $parameters = [])
    {
        return $this->_post('v1/customers', [ 'query' => $parameters ]);
    }

    public function update($id, array $parameters = [])
    {
        return $this->_post("v1/customers/{$id}", [ 'query' => $parameters ]);
    }

    public function delete($id)
    {
        return $this->_delete("v1/customers/{$id}");
    }

    public function find($id)
    {
        return $this->_get("v1/customers/{$id}");
    }

    public function all()
    {
        return $this->_get('v1/customers');
    }
}
