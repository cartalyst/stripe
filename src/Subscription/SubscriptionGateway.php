<?php namespace Cartalyst\Stripe\Subscription;
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
use Cartalyst\Stripe\StripeGateway;

class SubscriptionGateway extends StripeGateway {

	/**
	 * The subscription plan name.
	 *
	 * @var string
	 */
	protected $plan;

	/**
	 * The coupon to apply to the subscription.
	 *
	 * @var string
	 */
	protected $coupon;

	/**
	 * Indicates the "quantity" of the plan.
	 *
	 * @var int
	 */
	protected $quantity = 1;

	/**
	 * Indicates if the plan change should be prorated.
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
	 * Indicates if the trial should be immediately canceled for the operation.
	 *
	 * @var bool
	 */
	protected $skipTrial = false;

	/**
	 * The subscription object.
	 *
	 * @var \Cartalyst\Stripe\Subscription\IlluminateSubscription
	 */
	protected $subscription;

	/**
	 * Create a new Stripe gateway instance.
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
	 * Returns the Stripe subscription object.
	 *
	 * @return \Stripe_Subscription
	 */
	public function get()
	{
		return $this
				->getStripeCustomer()
				->subscriptions
				->retrieve($this->subscription->stripe_id);
	}

	/**
	 * Subscribe to the plan for the first time.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return void
	 */
	public function create($token, $attributes = [])
	{
		if ($id = $this->billable->getStripeId())
		{
			$customer = $this->updateStripeCustomer($id, array_get($attributes, 'customer', []));
		}
		else
		{
			$customer = $this->createStripeCustomer($token, array_get($attributes, 'customer', []));
		}

		$attributes = array_merge($attributes, [
			'plan'      => $this->plan,
			'coupon'    => $this->coupon,
			'prorate'   => $this->prorate,
			'quantity'  => $this->quantity,
			'trial_end' => $this->getTrialEndDate(),
		]);

		array_forget($attributes, 'customer');

		$subscription = $customer->subscriptions->create($attributes);

		$this->billable->subscriptions()->create([
			'plan'          => $this->plan,
			'active'        => 1,
			'ends_at'       => Carbon::createFromTimeStamp($subscription->current_period_end),
			'stripe_id'     => $subscription->id,
			'trial_ends_at' => $this->nullableTimestamp($subscription->trial_end),
		]);

		$this->updateLocalStripeData($this->getStripeCustomer($customer->id));
	}

	/**
	 * Updates the subscription.
	 *
	 * @param  array  $attributes
	 * @return void
	 */
	public function update(array $attributes = [])
	{
		$subscription = $this->get();

		foreach ($attributes as $key => $value)
		{
			$subscription->{$key} = $value;
		}

		$subscription->save();
	}

	/**
	 * Cancel the subscription.
	 *
	 * @param  bool  $atPeriodEnd
	 * @return void
	 */
	public function cancel($atPeriodEnd = false)
	{
		$subscription = $this->get();

		$subscription->cancel([
			'at_period_end' => $atPeriodEnd,
		]);

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
	}

	/**
	 * The subscription plan name.
	 *
	 * @param  string  $plan
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function onPlan($plan)
	{
		$this->plan = $plan;

		return $this;
	}

	/**
	 * Applies a coupon on the subscription.
	 *
	 * @param  string  $coupon
	 * @return void
	 */
	public function applyCoupon($coupon)
	{
		$subscription = $this->get();

		$subscription->coupon = $coupon;

		$subscription->save();
	}

	/**
	 * Removes the coupon from the subscription.
	 *
	 * @return void
	 */
	public function removeCoupon()
	{
		$subscription = $this->get();

		$subscription->deleteDiscount();
	}

	/**
	 * Cancel the billable entity's subscription at the end of the period.
	 *
	 * @return void
	 */
	public function cancelAtEndOfPeriod()
	{
		return $this->cancel(true);
	}

	/**
	 * Resume the subscription.
	 *
	 * @return void
	 */
	public function resume()
	{
		$subscription = $this->get();

		$this->update([
			'plan' => $subscription->plan->id,
		]);

		$this->updateLocalSubscriptionData([
			'active'        => 1,
			'ends_at'       => Carbon::createFromTimeStamp($subscription->current_period_end),
			'ended_at'      => null,
			'trial_ends_at' => $this->nullableTimestamp($subscription->trial_end),
			'canceled_at'   => null,
		]);
	}

	/**
	 * The coupon to apply to the subscription.
	 *
	 * @param  string  $coupon
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function withCoupon($coupon)
	{
		$this->coupon = $coupon;

		return $this;
	}

	/**
	 * Sets the quantity to apply to the subscription.
	 *
	 * @param  int  $quantity
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function quantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * Increment the quantity of the subscription.
	 *
	 * @param  int  $count
	 * @return void
	 */
	public function increment($count = 1)
	{
		$this->update([
			'quantity' => $this->get()->quantity + $count
		]);
	}

	/**
	 * Decrement the quantity of the subscription.
	 *
	 * @param  int  $count
	 * @return void
	 */
	public function decrement($count = 1)
	{
		$this->update([
			'quantity' => $this->get()->quantity - $count
		]);
	}

	/**
	 * Indicate that the plan change should be prorated.
	 *
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function prorate()
	{
		$this->prorate = true;

		return $this;
	}

	/**
	 * Indicate that the plan change should not be prorated.
	 *
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function noProrate()
	{
		$this->prorate = false;

		return $this;
	}

	/**
	 * Sets the subscription trial period.
	 *
	 * @param  \Carbon\Carbon  $period
	 * @return void
	 */
	public function setTrialPeriod(Carbon $period)
	{
		$this->update([
			'trial_end' => $period->getTimestamp(),
		]);

		$this->updateLocalSubscriptionData([
			'trial_ends_at' => $period,
		]);
	}

	/**
	 * Removes the trial period from the subscription.
	 *
	 * @return void
	 */
	public function removeTrialPeriod()
	{
		$this->update([
			'trial_end' => 'now',
		]);

		$this->updateLocalSubscriptionData([
			'trial_ends_at' => null,
		]);
	}

	/**
	 * Get the current trial end date for subscription change.
	 *
	 * @return \Carbon\Carbon
	 */
	public function getTrialFor()
	{
		return $this->trialEnd;
	}

	/**
	 * Specify the ending date of the trial.
	 *
	 * @param  \Carbon\Carbon  $trialEnd
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function trialFor(Carbon $trialEnd)
	{
		$this->trialEnd = $trialEnd;

		return $this;
	}

	/**
	 * Indicate that no trial should be enforced on the operation.
	 *
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	public function skipTrial()
	{
		$this->skipTrial = true;

		return $this;
	}

	/**
	 * Syncronizes the Stripe subscriptions data with the local data.
	 *
	 * @return void
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		$customer = $this->getStripeCustomer();

		$stripeSubscriptions = [];

		foreach ($customer->subscriptions->data as $subscription)
		{
			$stripeSubscriptions[$subscription->id] = $subscription;
		}

		// Loop through the current entity subscriptions, this is
		// to make sure that expired subscriptions are in sync.
		foreach ($entity->subscriptions as $subscription)
		{
			if ( ! array_get($stripeSubscriptions, $subscription->stripe_id) && ! $subscription->expired())
			{
				$subscription->update([
					'active'   => 0,
					'ended_at' => Carbon::now(),
				]);
			}
		}

		// Loop through the Stripe subscriptions
		foreach ($stripeSubscriptions as $subscription)
		{
			$stripeId = $subscription->id;

			$_subscription = $entity->subscriptions()->where('stripe_id', $stripeId)->first();

			$data = [
				'active'        => 1,
				'stripe_id'     => $stripeId,
				'plan'          => $subscription->plan->id,
				'created_at'    => Carbon::createFromTimestamp($subscription->current_period_start),
				'ends_at'       => Carbon::createFromTimestamp($subscription->current_period_end),
				'canceled_at'   => $this->nullableTimestamp($subscription->canceled_at),
				'trial_ends_at' => $this->nullableTimestamp($subscription->trial_end),
			];

			if ( ! $_subscription)
			{
				$entity->subscriptions()->create($data);
			}
			else
			{
				$_subscription->update($data);
			}
		}
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




	/**
	 * Maintain the days left of the current trial (if applicable).
	 *
	 * @return \Cartalyst\Stripe\Subscription\SubscriptionGateway
	 */
	// public function maintainTrial()
	// {
	// 	if ($this->billable->readyForBilling())
	// 	{
	// 		if ( ! is_null($trialEnd = $this->getTrialEndForCustomer($this->getStripeCustomer())))
	// 		{
	// 			$this->calculateRemainingTrialDays($trialEnd);
	// 		}
	// 		else
	// 		{
	// 			$this->skipTrial();
	// 		}
	// 	}

	// 	return $this;
	// }

	/**
	 * Get the trial end date for the customer's subscription.
	 *
	 * @param  object  $customer
	 * @return \Carbon\Carbon|null
	 */
	// public function getTrialEndForCustomer($customer)
	// {
	// 	if (isset($customer->subscription) && isset($customer->subscription->trial_end))
	// 	{
	// 		return Carbon::createFromTimestamp($customer->subscription->trial_end);
	// 	}
	// }

	/**
	 * Calculate the remaining trial days based on the current trial end.
	 *
	 * @param  \Carbon\Carbon  $trialEnd
	 * @return void
	 */
	// protected function calculateRemainingTrialDays($trialEnd)
	// {
	// 	// If there is still trial left on the current plan, we'll maintain that amount of
	// 	// time on the new plan. If there is no time left on the trial we will force it
	// 	// to skip any trials on this new plan, as this is the most expected actions.
	// 	$diff = Carbon::now()->diffInHours($trialEnd);

	// 	return $diff > 0 ? $this->trialFor(Carbon::now()->addHours($diff)) : $this->skipTrial();
	// }

	/**
	 * Get the subscription end timestamp for the customer.
	 *
	 * @param  object  $customer
	 * @return int
	 */
	// protected function getSubscriptionEndTimestamp($customer)
	// {
	// 	if ( ! is_null($customer->subscription->trial_end) && $customer->subscription->trial_end > time())
	// 	{
	// 		return $customer->subscription->trial_end;
	// 	}
	// 	else
	// 	{
	// 		return $customer->subscription->current_period_end;
	// 	}
	// }

	/**
	 * Swap the billable entity to a new plan.
	 *
	 * @param  int|null  $quantity
	 * @return void
	 */
	# this needs to be refactored as we support multiple subscriptions
	// public function swap($quantity = null)
	// {
	// 	$customer = $this->getStripeCustomer();

	// 	// If no specific trial end date has been set, the default behavior should be
	// 	// to maintain the current trial state, whether that is "active" or to run
	// 	// the swap out with the exact number of days left on this current plan.
	// 	if (is_null($this->trialEnd))
	// 	{
	// 		$this->maintainTrial();
	// 	}

	// 	// Again, if no explicit quantity was set, the default behaviors should be to
	// 	// maintain the current quantity onto the new plan. This is a sensible one
	// 	// that should be the expected behavior for most developers with Stripe.
	// 	if (isset($customer->subscription) && is_null($quantity))
	// 	{
	// 		$this->quantity(
	// 			$customer->subscription->quantity
	// 		);
	// 	}

	// 	return $this->create(null, null, $customer);
	// }


}
