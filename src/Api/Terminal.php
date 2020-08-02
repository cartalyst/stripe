<?php

declare(strict_types=1);

/*
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
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

use Cartalyst\Stripe\Api\Terminal\Readers;
use Cartalyst\Stripe\Api\Terminal\Locations;
use Cartalyst\Stripe\Api\Terminal\ConnectionTokens;

class Terminal extends AbstractApi
{
    /**
     * Returns a terminal connection tokens api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\ConnectionTokens
     */
    public function connectionTokens(): ConnectionTokens
    {
        return new ConnectionTokens($this->config);
    }

    /**
     * Returns a terminal locations api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\Locations
     */
    public function locations(): Locations
    {
        return new Locations($this->config);
    }

    /**
     * Returns a terminal readers api instance.
     *
     * @return \Cartalyst\Stripe\Api\Terminal\Readers
     */
    public function readers(): Readers
    {
        return new Readers($this->config);
    }
}
