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

class Tokens extends Api
{
    /**
     * Creates a new token.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function create(array $parameters)
    {
        return $this->_post('tokens', $parameters);
    }

    /**
     * Retrieves an existing token.
     *
     * @param  string  $tokenId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($tokenId)
    {
        return $this->_get("tokens/{$tokenId}");
    }
}
