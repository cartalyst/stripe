<?php namespace Cartalyst\Stripe\Billing;
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
use Cartalyst\Stripe\Billing\Models\IlluminateSubscription;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
	 * @var \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
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
	 * @param  \Cartalyst\Stripe\Billing\BillableInterface  $billable
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
	 * Returns the current Stripe subscription.
	 *
	 * @return array
	 */
	public function find()
	{
		$payload = $this->getPayload();

		return $this->client->subscriptions()->find($payload);
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

		// Prepares the payload
		$attributes = array_merge($attributes, [
			'customer'  => $entity->stripe_id,
			'plan'      => $this->plan,
			'coupon'    => $this->coupon,
			'prorate'   => $this->prorate,
			'quantity'  => $this->quantity,
			'trial_end' => $this->getTrialEndDate(),
		]);

		// Create the subscription on Stripe
		$subscription = $this->client->subscriptions()->create($attributes);

		// Attach the created subscription to the billable entity
		$entity->subscriptions()->create([
			'plan'          => $this->plan,
			'active'        => 1,
			'created_at'    => $this->nullableTimestamp($subscription['current_period_start']),
			'ends_at'       => $this->nullableTimestamp($subscription['current_period_end']),
			'stripe_id'     => $subscription['id'],
			'trial_ends_at' => $this->nullableTimestamp($subscription['trial_end']),
		]);

		// Fire the 'cartalyst.stripe.subscription.created' event
		$this->fire('subscription.created', [
			$entity,
			$subscription,
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
		$payload = $this->getPayload($attributes);

		$subscription = $this->client->subscriptions()->update($payload);

		// Fire the 'cartalyst.stripe.subscription.updated' event
		$this->fire('subscription.updated', [
			$this->billable,
			$subscription,
		]);

		return $subscription;
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

		$payload = $this->getPayload([
			'at_period_end' => $atPeriodEnd,
		]);

		$subscription = $this->client->subscriptions()->cancel($payload);

		// Fire the 'cartalyst.stripe.subscription.canceled' event
		$this->fire('subscription.canceled', [
			$this->billable,
			$subscription,
		]);

		return $subscription;
	}

	/**
	 * Resumes the subscription.
	 *
	 * @return array
	 */
	public function resume()
	{
		$subscription = $this->noProrate()->update([
			'plan' => $this->subscription->plan,
		]);

		$this->updateLocalSubscriptionData([
			'active'        => 1,
			'ends_at'       => $this->nullableTimestamp($subscription['current_period_end']),
			'ended_at'      => null,
			'trial_ends_at' => $this->nullableTimestamp($subscription['trial_end']),
			'canceled_at'   => null,
		]);

		// Fire the 'cartalyst.stripe.subscription.resumed' event
		$this->fire('subscription.resumed', [
			$this->billable,
			$subscription,
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

	/**
	 * Sets the token for the new card.
	 *
	 * @param  string  $token
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * The subscription plan name.
	 *
	 * @param  string  $plan
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function onPlan($plan)
	{
		$this->plan = $plan;

		return $this;
	}

	/**
	 * The discount that'll be applied to the subscription.
	 *
	 * @param  string  $coupon
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function withCoupon($coupon)
	{
		$this->coupon = $coupon;

		return $this;
	}

	/**
	 * Applies a discount to the subscription.
	 *
	 * @param  string  $coupon
	 * @return array
	 */
	public function applyCoupon($coupon)
	{
		return $this->update(compact('coupon'));
	}

	/**
	 * Removes the discount from the subscription.
	 *
	 * @return array
	 */
	public function removeCoupon()
	{
		$payload = $this->getPayload();

		return $this->client->subscriptions()->deleteDiscount($payload);
	}

	/**
	 * The quantity that'll be applied to the subscription.
	 *
	 * @param  int  $quantity
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function quantity($quantity)
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * Increments the subscription quantity.
	 *
	 * @param  int  $amount
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function increment($amount = 1)
	{
		$quantity = $this->find()['quantity'];

		return $this->updateQuantity($quantity + $amount);
	}

	/**
	 * Decrements the subscription quantity.
	 *
	 * @param  int  $amount
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function decrement($amount = 1)
	{
		$quantity = $this->find()['quantity'];

		return $this->updateQuantity($quantity - $amount);
	}

	/**
	 * Updates the subscription quantity.
	 *
	 * @param  int  $quantity
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function updateQuantity($quantity)
	{
		return $this->update(compact('quantity'));
	}

	/**
	 * Indicates that the plan change should be prorated.
	 *
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function prorate()
	{
		$this->prorate = true;

		return $this;
	}

	/**
	 * Indicates that the plan change should not be prorated.
	 *
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function noProrate()
	{
		$this->prorate = false;

		return $this;
	}

	/**
	 * Specify the endig date of the trial.
	 *
	 * @param  \Carbon\Carbon  $trialEnd
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function trialFor(Carbon $trialEnd)
	{
		$this->trialEnd = $trialEnd;

		return $this;
	}

	/**
	 * Sets the trial period of the subscription.
	 *
	 * @param  \Carbon\Carbon  $period
	 * @return array
	 */
	public function setTrialPeriod(Carbon $period)
	{
		$subscription = $this->update([
			'trial_end' => $period->getTimestamp(),
		]);

		$this->updateLocalSubscriptionData([
			'trial_ends_at' => $period,
		]);

		return $subscription;
	}

	/**
	 * Removes the trial period of the subscription.
	 *
	 * @return array
	 */
	public function removeTrialPeriod()
	{
		$subscription = $this->update([
			'trial_end' => 'now',
		]);

		$this->updateLocalSubscriptionData([
			'trial_ends_at' => null,
		]);

		return $subscription;
	}

	/**
	 * Indicates that the subscription shouldn't
	 * have any trial end period.
	 *
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	public function skipTrial()
	{
		$this->skipTrial = true;

		return $this;
	}

	/**
	 * Swap the billable entity to a new plan.
	 *
	 * @return array
	 */
	public function swap()
	{
		if ( ! $this->trialEnd && ! $this->skipTrial)
		{
			$this->maintainTrial();
		}

		$subscription = $this->update([
			'plan'      => $this->plan,
			'trial_end' => $this->getTrialEndDate(),
		]);

		$this->updateLocalSubscriptionData([
			'plan'          => $this->plan,
			'trial_ends_at' => $this->trialEnd,
		]);

		return $subscription;
	}

	/**
	 * Syncronizes the Stripe subscriptions data with the local data.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		if ( ! $entity->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		$subscriptions = $this->client->subscriptionsIterator([
			'customer' => $entity->stripe_id,
		]);

		$stripeSubscriptions = [];

		foreach ($subscriptions as $subscription)
		{
			$stripeSubscriptions[$subscription['id']] = $subscription;
		}

		// Loop through the current entity subscriptions, this is
		// to make sure that expired subscriptions are in sync.
		foreach ($entity->subscriptions as $subscription)
		{
			if ( ! array_get($stripeSubscriptions, $subscription->stripe_id) && ! $subscription->expired())
			{
				$subscription->update([
					'active'        => 0,
					'ended_at'      => Carbon::now(),
					'canceled_at'   => null,
					'trial_ends_at' => null,
				]);
			}
		}

		// Loop through the Stripe subscriptions
		foreach ($stripeSubscriptions as $subscription)
		{
			$stripeId = $subscription['id'];

			$_subscription = $entity->subscriptions()->where('stripe_id', $stripeId)->first();

			$data = [
				'active'        => 1,
				'stripe_id'     => $stripeId,
				'plan'          => $subscription['plan']['id'],
				'created_at'    => $this->nullableTimestamp($subscription['current_period_start']),
				'ends_at'       => $this->nullableTimestamp($subscription['current_period_end']),
				'canceled_at'   => $this->nullableTimestamp($subscription['canceled_at']),
				'trial_ends_at' => $this->nullableTimestamp($subscription['trial_end']),
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
	 * Maintain the days left of the current trial (if applicable).
	 *
	 * @return \Cartalyst\Stripe\Billing\SubscriptionGateway
	 */
	protected function maintainTrial()
	{
		if ($trialEnd = $this->getSubscriptionTrialEnd())
		{
			$this->calculateRemainingTrialDays($trialEnd);
		}
		else
		{
			$this->skipTrial();
		}

		return $this;
	}

	/**
	 * Get the trial end date for the customer's subscription.
	 *
	 * @return \Carbon\Carbon|null
	 */
	protected function getSubscriptionTrialEnd()
	{
		if ($this->subscription && $this->subscription->trial_ends_at)
		{
			return $this->subscription->trial_ends_at;
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
	 * Calculate the remaining trial days based on the current trial end.
	 *
	 * @param  \Carbon\Carbon  $trialEnd
	 * @return mixed
	 */
	protected function calculateRemainingTrialDays($trialEnd)
	{
		$diff = Carbon::now()->diffInHours($trialEnd);

		return $diff > 0 ? $this->trialFor(Carbon::now()->addHours($diff)) : $this->skipTrial();
	}

	/**
	 * Returns the request payload.
	 *
	 * @param  array  $attributes
	 * @return array
	 */
	protected function getPayload(array $attributes = [])
	{
		return array_merge($attributes, [
			'customer' => $this->billable->stripe_id,
			'id'       => $this->subscription->stripe_id,
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
