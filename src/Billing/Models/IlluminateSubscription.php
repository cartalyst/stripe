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
		'ends_at',
		'plan_id',
		'ended_at',
		'stripe_id',
		'created_at',
		'canceled_at',
		'trial_ends_at',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'ends_at',
		'ended_at',
		'canceled_at',
		'trial_ends_at',
	];

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
	 * Determine if the subscription is within the trial period.
	 *
	 * @return bool
	 */
	public function onTrialPeriod()
	{
		$endsAt = $this->ends_at;

		if ($endsAt && $this->trial_ends_at)
		{
			return Carbon::today()->lt(Carbon::instance($endsAt));
		}

		return false;
	}

	/**
	 * Determine if the subscription is on grace period after cancellation.
	 *
	 * @return bool
	 */
	public function onGracePeriod()
	{
		$canceledAt = $this->canceled_at;

		if ($canceledAt && ! $this->ended_at)
		{
			return Carbon::today()->lt(Carbon::instance($canceledAt));
		}

		return false;
	}

	/**
	 * Determine if the subscription is no longer active.
	 *
	 * @return bool
	 */
	public function canceled()
	{
		return (bool) $this->canceled_at;
	}

	/**
	 * Determine if the subscription has expired.
	 *
	 * @return bool
	 */
	public function expired()
	{
		return ($this->active === false && $this->ended_at && ! $this->canceled_at);
	}

}
