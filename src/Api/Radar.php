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

class Radar extends Api
{
    /**
     * Returns a radar early fraud warning api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\Reviews
     */
    public function earlyFraudWarning()
    {
        return new Radar\EarlyFraudWarning($this->config);
    }

    /**
     * Returns a radar reviews api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\Reviews
     */
    public function reviews()
    {
        return new Radar\Reviews($this->config);
    }

    /**
     * Returns a radar value lists api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\ValueLists
     */
    public function valueLists()
    {
        return new Radar\ValueLists($this->config);
    }

    /**
     * Returns a radar value list items api instance.
     *
     * @return \Cartalyst\Stripe\Api\Radar\ValueListItems
     */
    public function valueListItems()
    {
        return new Radar\ValueListItems($this->config);
    }
}
