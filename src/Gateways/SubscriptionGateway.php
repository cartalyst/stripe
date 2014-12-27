<?php namespace Cartalyst\Stripe\Gateways;
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
use Cartalyst\Stripe\BillableInterface;
use Cartalyst\Stripe\Models\IlluminateSubscription;

class SubscriptionGateway extends AbstractGateway {

	/**
	 * The subscription plan name.
	 *
	 * @var string
	 */
	protected $plan;

	/**
	 * The coupon that will be applied on the subscription.
	 *
	 * @var string
	 */
	protected $coupon;

	/**
	 * Indicates the subscription quantity.
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
	 * @var \Cartalyst\Stripe\Models\IlluminateSubscription
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
	 * @param  mixed  $id
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $id = null)
	{
		parent::__construct($billable);

		$subscription = $this->billable->subscriptions()->getModel()->find($id);

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
		return $this->client->subscriptions()->find(
			$this->getPayload()
		);
	}

	/**
	 * Creates a new subscription on the entity.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function create(array $attributes = [])
	{
		// Fetch this entity Stripe customer
		$this->billable->findOrCreateStripeCustomer(
			array_get($attributes, 'customer', [])
		);

		// If a stripe token is provided, we'll use it and
		// attach the credit card to the Stripe customer,
		// it will makes it the default credit card.
		if ($token = $this->token)
		{
			$card = array_pull($attributes, 'card', []);

			$this->billable->card()->makeDefault()->create($token, $card);
		}

		// Prepare the payload
		$payload = array_merge($attributes, [
			'customer'  => $this->billable->stripe_id,
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function update(array $attributes = [])
	{
		// Check if a valid subscription is selected
		$this->checkSubscriptionIsValid();

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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function cancel($atPeriodEnd = false)
	{
		// Check if a valid subscription is selected
		$this->checkSubscriptionIsValid();

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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function resume()
	{
		// Check if a valid subscription is selected
		$this->checkSubscriptionIsValid();

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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
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
		// Check if a valid subscription is selected
		$this->checkSubscriptionIsValid();

		return $this->client->subscriptions()->deleteDiscount(
			$this->getPayload()
		);
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function setTrialPeriod(Carbon $period)
	{
		return $this->update([
			'plan'      => $this->subscription->plan_id,
			'trial_end' => $period->getTimestamp(),
		]);
	}

	/**
	 * Removes the trial period of the subscription.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function removeTrialPeriod()
	{
		return $this->update([
			'plan'      => $this->subscription->plan_id,
			'trial_end' => 'now',
		]);
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
	 * @param  string  $plan
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	public function swap($plan)
	{
		// Check if we should maintain the subscription trial period
		if ( ! $this->trialEnd && ! $this->skipTrial)
		{
			$this->maintainTrial();
		}

		// Update the subscription on Stripe
		return $this->update([
			'plan'      => $plan,
			'trial_end' => $this->getTrialEndDate(),
		]);
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
		// Check if the entity is a stripe customer
		$this->checkEntityIsBillable();

		// Prepare the expand array
		$expand = array_get($arguments, 'expand', []);
		foreach ($expand as $key => $value)
		{
			$expand[$key] = "data.{$value}";
		}
		array_set($arguments, 'expand', $expand);

		// Prepare the payload
		$payload = array_merge($arguments, [
			'customer' => $this->billable->stripe_id,
		]);

		// Remove the "callback" from the arguments, this is passed
		// through the main syncWithStripe method, so we remove it
		// here anyways so that we can have a proper payload.
		$callback = array_pull($payload, 'callback', $callback);

		// Get all the active subscriptions
		foreach ($this->client->subscriptionsIterator($payload) as $subscription)
		{
			$this->storeSubscription($subscription);
		}

		// Get the entity subscriptions from storage
		$subscriptions = $this->billable->subscriptions()->lists('stripe_id');

		// Get all the expired subscriptions
		$events = array_reverse($this->client->eventsIterator([
			'object_id' => $this->billable->stripe_id,
			'type'      => 'customer.subscription.deleted',
		])->toArray());

		foreach ($events as $event)
		{
			$subscription = array_get($event, 'data.object');

			// Before 2014-01-31, Stripe only allowed one subscription per
			// customer, therefore the subscription didn't had an id.
			// To solve the issue, we'll use the Event id instead.
			if ( ! isset($subscription['id']))
			{
				$subscription['id'] = str_replace('evt', 'sub', $event['id']);
			}

			$active = array_key_exists($subscription['id'], $subscriptions);

			$this->storeSubscription($subscription, compact('active'));
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
	 * @return \Cartalyst\Stripe\Models\IlluminateSubscription
	 */
	protected function storeSubscription($response, array $attributes = [], Closure $callback = null)
	{
		// Get the subscription id
		$stripeId = $response['id'];

		// Find the subscription on storage
		$subscription = $this->billable->subscriptions()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $subscription ? 'created' : 'updated';

		// Get the ended date of this subscription
		$endedAt = $this->nullableTimestamp($response['ended_at']);

		// Prepare the payload
		$payload = array_merge([
			'stripe_id'        => $stripeId,
			'plan_id'          => $this->plan ?: $response['plan']['id'],
			'active'           => true,
			'created_at'       => $this->nullableTimestamp($response['start']),
			'updated_at'       => $this->nullableTimestamp($response['start']),
			'period_starts_at' => $this->nullableTimestamp($response['current_period_start']),
			'period_ends_at'   => $this->nullableTimestamp($response['current_period_end']),
			'ended_at'         => $endedAt,
			'canceled_at'      => $this->nullableTimestamp( ! $endedAt ? $response['canceled_at'] : null),
			'trial_starts_at'  => $this->nullableTimestamp( ! $endedAt ? $response['trial_start'] : null),
			'trial_ends_at'    => $this->nullableTimestamp( ! $endedAt ? $response['trial_end'] : null),
		], $attributes);

		// Does the subscription exist on storage?
		if ( ! $subscription)
		{
			$model = $this->billable->getSubscriptionModel();

			$subscription = $this->billable->subscriptions()->save(new $model($payload));
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

	/**
	 * Checks if a valid subscription was selected.
	 *
	 * @return void
	 * @throws \RuntimeException
	 */
	protected function checkSubscriptionIsValid()
	{
		if ( ! $this->subscription)
		{
			$method = debug_backtrace()[1]['function'];

			throw new \RuntimeException(
				"Calling the '{$method}' method on an invalid or non existing subscription is not allowed!"
			);
		}
	}

}
