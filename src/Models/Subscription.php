<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Models;

use Carbon\Carbon;

class Subscription extends Collection
{
    /**
     * Determines if the subscription is within the trial period.
     *
     * @return bool
     */
    public function onTrialPeriod()
    {
        if ($endsAt = $this->trial_end) {
            return Carbon::today()->lt(Carbon::createFromTimeStamp($endsAt));
        }

        return false;
    }

    /**
     * Determines if the subscription is on grace period after cancellation.
     *
     * @return bool
     */
    public function onGracePeriod()
    {
        if ($this->canceled_at && ! $this->ended_at) {
            return Carbon::today()->lt(Carbon::createFromTimeStamp($this->current_period_end));
        }

        return false;
    }

    /**
     * Determines if the subscription is no longer active.
     *
     * @return bool
     */
    public function isCanceled()
    {
        return (bool) $this->canceled_at;
    }
}
