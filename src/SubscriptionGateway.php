<?php namespace Cartalyst\Stripe;
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
use Cartalyst\Stripe\BillableInterface;
use Cartalyst\Stripe\Models\IlluminateSubscription;

class SubscriptionGateway extends StripeGateway {

	/**
	 * The subscription plan name.
	 *
	 * @var string
	 */
	protected $plan;

	/**
	 * The coupon that will be applied
	 *
	 * @var string
	 */
	protected $coupon;

	/**
	 * Indicates the quantity of the subscription.
	 *
	 * @var int
	 */
	protected $quantity = 1;

	/**
	 * Indicates if the subscription plan change should be prorated.
	 *
	 * @var bool
	 */
	protected $prorate = true;

	/**
	 * The subscription trial end date.
	 *
	 * @var \Carbon\Carbon
	 */
	protected $trialEnd;

	/**
	 * Indicates if the trial should be canceled.
	 *
	 * @var bool
	 */
	protected $skipTrial = false;

	/**
	 * The subscription object.
	 *
	 * @var \Cartalyst\Stripe\IlluminateSubscription
	 */
	protected $subscription;

	/**
	 * The token for the new credit card.
	 *
	 * @var string
	 */
	protected $token;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @param  mixed  $subscription
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $subscription = null)
	{
		parent::__construct($billable);

		if (is_numeric($subscription))
		{
			$subscription = $this->billable->subscriptions->find($subscription);
		}

		if ($subscription instanceof IlluminateSubscription)
		{
			$this->subscription = $subscription;
		}
	}

	/**
	 * Creates a new subscription on the entity.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function create(array $attributes = [])
	{
		// Get the entity object
		$entity = $this->billable;

		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$entity->stripe_id,
			array_get($attributes, 'customer', [])
		);

		// If a stripe token is provided, we'll use it and
		// attach the credit card to the Stripe customer.
		if ($token = $this->token)
		{
			$entity->card()->makeDefault()->create(
				$token,
				array_get($attributes, 'card', [])
			);
		}

		// Prepare the subscription data
		$attributes = array_merge($attributes, [
			'customer'  => $customer['id'],
			'plan'      => $this->plan,
			'coupon'    => $this->coupon,
			'prorate'   => $this->prorate,
			'quantity'  => $this->quantity,
			'trial_end' => $this->getTrialEndDate(),
		]);

		// Create the Stripe subscription
		$subscription = $this->client->subscriptions()->create($attributes)->toArray();

		// Attach the created subscription to the billable entity
		$entity->subscriptions()->create([
			'plan'          => $this->plan,
			'active'        => 1,
			'ends_at'       => Carbon::createFromTimeStamp($subscription['current_period_end']),
			'stripe_id'     => $subscription['id'],
			'trial_ends_at' => $this->nullableTimestamp($subscription['trial_end']),
		]);
	}

	/**
	 * Updates the subscription.
	 *
	 * @param  array  $attributes
	 * @return array
	 */
	public function update(array $attributes = [])
	{
		$payload = $this->getSubscriptionPayload($attributes);

		return $this->client->subscriptions()->update($payload)->toArray();
	}

	/**
	 * Cancels the subscription.
	 *
	 * @param  bool  $atPeriodEnd
	 * @return array
	 */
	public function cancel($atPeriodEnd = false)
	{
		$data = [
			'canceled_at' => Carbon::now(),
		];

		if ( ! $atPeriodEnd)
		{
			$data = array_merge($data, [
				'active'        => 0,
				'ended_at'      => Carbon::now(),
				'trial_ends_at' => null,
			]);
		}

		$this->updateLocalSubscriptionData($data);

		$payload = $this->getSubscriptionPayload([
			'at_period_end' => $atPeriodEnd ? 'true' : 'false',
		]);

		return $this->client->subscriptions()->cancel($payload)->toArray();
	}

	/**
	 * Resumes the subscription.
	 *
	 * @return array
	 */
	public function resume()
	{
		$subscription = $this->update([
			'plan' => $this->subscription->plan,
		]);

		$this->updateLocalSubscriptionData([
			'active'        => 1,
			'ends_at'       => Carbon::createFromTimeStamp($subscription['current_period_end']),
			'ended_at'      => null,
			'trial_ends_at' => $this->nullableTimestamp($subscription['trial_end']),
			'canceled_at'   => null,
		]);

		return $subscription;
	}


	/**
	 * Cancels the subscription at the end of the period.
	 *
	 * @return array
	 */
	public function cancelAtEndOfPeriod()
	{
		return $this->cancel(true);
	}




	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	public function onPlan($plan)
	{
		$this->plan = $plan;

		return $this;
	}

	public function withCoupon($coupon)
	{
		$this->coupon = $coupon;

		return $this;
	}

	public function quantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	public function prorate()
	{
		$this->prorate = true;

		return $this;
	}

	public function noProrate()
	{
		$this->prorate = false;

		return $this;
	}

	public function trialFor(Carbon $trialEnd)
	{
		$this->trialEnd = $trialEnd;

		return $this;
	}

	public function skipTrial()
	{
		$this->skipTrial = true;

		return $this;
	}

	public function maintainTrial()
	{
		//
	}

	/**
	 * Returns the trial end timestamp.
	 *
	 * @return int
	 */
	protected function getTrialEndDate()
	{
		if ($this->skipTrial) return 'now';

		return $this->trialEnd ? $this->trialEnd->getTimestamp() : null;
	}



	protected function getSubscriptionPayload($attributes)
	{
		return array_merge($attributes, [
			'id'       => $this->subscription->stripe_id,
			'customer' => $this->billable->stripe_id,
		]);
	}



	/**
	 * Updates the local subscription data.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	protected function updateLocalSubscriptionData(array $attributes = [])
	{
		$this->subscription->fill($attributes)->save();
	}

}
