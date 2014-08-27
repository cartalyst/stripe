<?php namespace Cartalyst\Stripe\Billing\Gateways;
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

use Closure;
use Carbon\Carbon;
use Cartalyst\Stripe\Billing\BillableInterface;
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
	 * The Eloquent subscription object.
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
		return $this->client->subscriptions()->find($this->getPayload());
	}

	/**
	 * Creates a new subscription on the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
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

		// Prepare the payload
		$payload = array_merge($attributes, [
			'customer'  => $entity->stripe_id,
			'plan'      => $this->plan,
			'coupon'    => $this->coupon,
			'prorate'   => $this->prorate,
			'quantity'  => $this->quantity,
			'trial_end' => $this->getTrialEndDate(),
		]);

		// Create the subscription on Stripe
		$response = $this->client->subscriptions()->create($payload);

		// Attach the created subscription to the billable entity
		return $this->storeSubscription($response);
	}

	/**
	 * Updates the subscription.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function update(array $attributes = [])
	{
		// Prepare the payload
		$payload = $this->getPayload($attributes);

		// Update the subscription on Stripe
		$response = $this->client->subscriptions()->update($payload);

		// Update the subscription on storage
		return $this->storeSubscription($response);
	}

	/**
	 * Cancels the subscription.
	 *
	 * @param  bool  $atPeriodEnd
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function cancel($atPeriodEnd = false)
	{
		// Prepare the payload
		$payload = $this->getPayload([ 'at_period_end' => $atPeriodEnd ]);

		// Cancel the subscription on Stripe
		$response = $this->client->subscriptions()->cancel($payload);

		// Prepare the data for the subscription cancelation
		$data = [
			'canceled_at' => Carbon::now(),
		];

		if ( ! $atPeriodEnd)
		{
			$data = array_merge($data, [
				'active'        => false,
				'ended_at'      => Carbon::now(),
				'trial_ends_at' => null,
			]);
		}

		// Disable the event dispatcher
		$this->disableEventDispatcher();

		// Update the subscription on storage
		$subscription = $this->storeSubscription($response, $data);

		// Enable the event dispatcher
		$this->enableEventDispatcher();

		// Fire the 'cartalyst.stripe.subscription.canceled' event
		$this->fire('subscription.canceled', [ $response, $subscription ]);

		return $subscription;
	}

	/**
	 * Resumes the subscription.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function resume()
	{
		// Disable the event dispatcher
		$this->disableEventDispatcher();

		// Check if we should maintain the subscription trial period
		if ( ! $this->trialEnd && ! $this->skipTrial)
		{
			$this->maintainTrial();
		}

		// Prepare the payload
		$payload = $this->getPayload([
			'plan'      => $this->subscription->plan_id,
			'trial_end' => $this->getTrialEndDate(),
		]);

		// Update the subscription on Stripe
		$response = $this->client->subscriptions()->update($payload);

		// Update the subscription on storage
		$subscription = $this->storeSubscription($response, [
			'ended_at'    => null,
			'canceled_at' => null,
		]);

		// Enable the event dispatcher
		$this->enableEventDispatcher();

		// Fire the 'cartalyst.stripe.subscription.resumed' event
		$this->fire('subscription.resumed', [ $response, $subscription ]);

		return $subscription;
	}

	/**
	 * Cancels the subscription at the end of the period.
	 *
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function cancelAtEndOfPeriod()
	{
		return $this->cancel(true);
	}

	/**
	 * Sets the token for the new card.
	 *
	 * @param  string  $token
	 * @return $this
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
	 * @return $this
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
	 * @return $this
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
	 * @return $this
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
	 * @return $this
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
	 * @return $this
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
	 * @return $this
	 */
	public function updateQuantity($quantity)
	{
		return $this->update(compact('quantity'));
	}

	/**
	 * Indicates that the plan change should be prorated.
	 *
	 * @return $this
	 */
	public function prorate()
	{
		$this->prorate = true;

		return $this;
	}

	/**
	 * Indicates that the plan change should not be prorated.
	 *
	 * @return $this
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
	 * @return $this
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

		$this->storeSubscription($subscription, [
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

		$this->storeSubscription($subscription, [
			'trial_ends_at' => null,
		]);

		return $subscription;
	}

	/**
	 * Indicates that the subscription shouldn't
	 * have any trial end period.
	 *
	 * @return $this
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
		// Check if we should maintain the subscription trial period
		if ( ! $this->trialEnd && ! $this->skipTrial)
		{
			$this->maintainTrial();
		}

		// Update the subscription on Stripe
		$subscription = $this->update([
			'plan'      => $this->plan,
			'trial_end' => $this->getTrialEndDate(),
		]);

		// Update the subscription on storage
		$this->storeSubscription($subscription, [
			'plan_id'       => $this->plan,
			'trial_ends_at' => $this->trialEnd,
		]);

		return $subscription;
	}

	/**
	 * Syncronizes the Stripe subscriptions data with the local data.
	 *
	 * @param  array  $arguments
	 * @param  \Closure  $callback
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe(array $arguments = [], Closure $callback = null)
	{
		// Get the entity object
		$entity = $this->billable;

		// Check if the entity is a stripe customer
		if ( ! $entity->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		// Prepare the expand array
		$expand = array_get($arguments, 'expand', []);
		foreach ($expand as $key => $value)
		{
			$expand[$key] = "data.{$value}";
		}
		array_set($arguments, 'expand', $expand);

		// Prepare the payload
		$payload = array_merge($arguments, [
			'customer' => $entity->stripe_id,
		]);

		// Remove the "callback" from the arguments, this is passed
		// through the main syncWithStripe method, so we remove it
		// here anyways so that we can have a proper payload.
		$callback = array_get($payload, 'callback', $callback);
		array_forget($payload, 'callback');

		// Get all the current entity subscriptions
		$subscriptions = [];

		foreach ($this->client->subscriptionsIterator($payload) as $subscription)
		{
			$subscriptions[$subscription['id']] = $subscription;
		}

		// Get all the 'customer.subscription.created'
		// events for this stripe customer.
		$events = $this->client->events()->all([
			//'customer' => $entity->stripe_id,
			'type'     => 'customer.subscription.created',
		])['data'];

		$subscriptionsFromEvents = [];

		foreach (array_reverse($events) as $event)
		{
			$subscription = array_get($event, 'data.object');

			if ($subscription['customer'] != $entity->stripe_id) continue;

			$subscriptionsFromEvents[$subscription['id']] = $subscription;
		}

		// Loop through the current entity subscriptions, this is
		// to make sure that expired subscriptions are in sync.
		foreach ($entity->subscriptions as $subscription)
		{
			if ( ! array_get($subscriptions, $subscription->stripe_id) && ! $subscription->isExpired())
			{
				$subscription->update([
					'active'        => false,
					'ended_at'      => Carbon::now(),
					'canceled_at'   => null,
					'trial_ends_at' => null,
				]);
			}
		}

		// Loop through the Stripe subscriptions
		foreach ($subscriptionsFromEvents as $subscription)
		{
			$active = array_key_exists($subscription['id'], $subscriptions);

			$subscription = $this->storeSubscription($subscription, compact('active'));
		}
	}

	/**
	 * Maintain the days left of the current trial (if applicable).
	 *
	 * @return $this
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
	 * Stores the subscription information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @param  array  $attributes
	 * @param  \Closure  $callback
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	protected function storeSubscription($response, array $attributes = [], Closure $callback = null)
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the subscription id
		$stripeId = $response['id'];

		// Find the subscription on storage
		$subscription = $entity->subscriptions()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $subscription ? 'created' : 'updated';

		// Prepare the payload
		$payload = array_merge([
			'stripe_id'        => $stripeId,
			'plan_id'          => $this->plan ?: $response['plan']['id'],
			'active'           => true,
			'period_starts_at' => $this->nullableTimestamp($response['current_period_start']),
			'period_ends_at'   => $this->nullableTimestamp($response['current_period_end']),
			'canceled_at'      => $this->nullableTimestamp($response['canceled_at']),
			'trial_starts_at'  => $this->nullableTimestamp($response['trial_start']),
			'trial_ends_at'    => $this->nullableTimestamp($response['trial_end']),
		], $attributes);

		// Does the subscription exist on storage?
		if ( ! $subscription)
		{
			$subscription = $entity->subscriptions()->create($payload);
		}
		else
		{
			$subscription->update($payload);
		}

		if ($callback)
		{
			call_user_func($callback, $response, $subscription);
		}

		// Fires the appropriate event
		$this->fire("subscription.{$event}", [ $response, $subscription ]);

		return $subscription;
	}

}
