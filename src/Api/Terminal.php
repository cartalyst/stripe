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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Terminal extends Api
{
    /**
     * Returns a terminal connection tokens api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\ConnectionTokens
     */
    public function connectionTokens()
    {
        return new Terminal\ConnectionTokens($this->config);
    }

    /**
     * Returns a terminal locations api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\Locations
     */
    public function locations()
    {
        return new Terminal\Locations($this->config);
    }

    /**
     * Returns a terminal readers api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\Readers
     */
    public function readers()
    {
        return new Terminal\Readers($this->config);
    }
}
