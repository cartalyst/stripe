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

use Cartalyst\Stripe\Api\Checkout\Sessions;

class Checkout extends AbstractApi
{
    /**
     * Returns a checkout sessions api instance.
     *
     * @return \Cartalyst\Stripe\Api\Checkout\Sessions
     */
    public function sessions(): Sessions
    {
        return new Sessions($this->config);
    }
}
