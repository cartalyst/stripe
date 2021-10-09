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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Tokens extends Api
{
    /**
     * Creates a new token.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters)
    {
        return $this->_post('tokens', $parameters);
    }

    /**
     * Retrieves an existing token.
     *
     * @param  string  $tokenId
     * @return array
     */
    public function find($tokenId)
    {
        return $this->_get("tokens/{$tokenId}");
    }
}
