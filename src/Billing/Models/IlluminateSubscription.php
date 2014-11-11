<?php namespace Cartalyst\Stripe\Billing\Models;
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
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IlluminateSubscription extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'subscriptions';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'active',
		'plan_id',
		'ended_at',
		'stripe_id',
		'created_at',
		'updated_at',
		'canceled_at',
		'trial_ends_at',
		'period_ends_at',
		'trial_starts_at',
		'period_starts_at',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'ended_at',
		'created_at',
		'updated_at',
		'canceled_at',
		'trial_ends_at',
		'period_ends_at',
		'period_starts_at',
	];

	/**
	 * Returns the polymorphic relationship.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function billable()
	{
		return $this->morphTo();
	}

	/**
	 * Get mutator for the "active" attribute
	 *
	 * @return bool
	 */
	public function getActiveAttribute($active)
	{
		return (bool) $active;
	}

	/**
	 * Determines if the subscription is within the trial period.
	 *
	 * @return bool
	 */
	public function onTrialPeriod()
	{
		if ($endsAt = $this->trial_ends_at)
		{
			return Carbon::today()->lt(Carbon::instance($endsAt));
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
		if ($this->canceled_at && ! $this->ended_at)
		{
			return Carbon::today()->lt(Carbon::instance($this->period_ends_at));
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

	/**
	 * Determines if the subscription has expired.
	 *
	 * @return bool
	 */
	public function isExpired()
	{
		return ($this->active === false && $this->ended_at && ! $this->canceled_at);
	}

}
