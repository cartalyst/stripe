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

use Cartalyst\Stripe\Api\Radar\Reviews;
use Cartalyst\Stripe\Api\Radar\ValueLists;
use Cartalyst\Stripe\Api\Radar\ValueListItems;
use Cartalyst\Stripe\Api\Radar\EarlyFraudWarning;

class Radar extends Api
{
    /**
     * Returns a radar early fraud warning api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\EarlyFraudWarning
     */
    public function earlyFraudWarning(): EarlyFraudWarning
    {
        return new EarlyFraudWarning($this->config);
    }

    /**
     * Returns a radar reviews api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\Reviews
     */
    public function reviews(): Reviews
    {
        return new Reviews($this->config);
    }

    /**
     * Returns a radar value lists api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\ValueLists
     */
    public function valueLists(): ValueLists
    {
        return new ValueLists($this->config);
    }

    /**
     * Returns a radar value list items api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\ValueListItems
     */
    public function valueListItems(): ValueListItems
    {
        return new ValueListItems($this->config);
    }
}
