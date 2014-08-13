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

use Cartalyst\Stripe\Billing\BillableInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateCharge;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChargeGateway extends StripeGateway {

	/**
	 * The Eloquent charge object.
	 *
	 * @var \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	protected $charge;

	/**
	 * Flag to wether capture the charge or not.
	 *
	 * @var bool
	 */
	protected $capture = true;

	/**
	 * Indicates the charge currency.
	 *
	 * @var stirng
	 */
	protected $currency = 'usd';

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
	 * @param  mixed  $charge
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $charge = null)
	{
		parent::__construct($billable);

		if (is_numeric($charge))
		{
			$charge = $this->billable->charges->find($charge);
		}

		if ($charge instanceof IlluminateCharge)
		{
			$this->charge = $charge;
		}
	}

	/**
	 * Creates a new charge on the entity.
	 *
	 * @param  int  $amount
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function create($amount, array $attributes = [])
	{
		// Get the entity object
		$entity = $this->billable;

		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$entity->stripe_id,
			array_get($attributes, 'customer', [])
		);

		array_forget($attributes, 'customer');

		// Get the current default card identifier
		$card = $customer['default_card'];

		// If a stripe token is provided, we'll use it and
		// attach the credit card to the Stripe customer.
		if ($this->token)
		{
			$card = $entity->card()->makeDefault()->create(
				$this->token,
				array_get($attributes, 'card', [])
			);

			$card = $card['stripe_id'];
		}

		// Prepare the payload
		$payload = array_merge([
			'customer' => $entity->stripe_id,
			'capture'  => $this->capture,
			'currency' => $this->currency,
			'amount'   => $amount,
			'card'     => $card,
		], $attributes);

		// Create the charge on Stripe
		$response = $this->client->charges()->create($payload);

		// Attach the created charge to the billable entity
		return $this->storeCharge($response);
	}

	/**
	 * Updates the charge.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function update(array $attributes = [])
	{
		// Prepare the payload
		$payload = $this->getPayload($attributes);

		// Update the charge on Stripe
		$response = $this->client->charges()->update($payload);

		// Update the charge on storage
		return $this->storeCharge($response);
	}

	/**
	 * Refunds the charge.
	 *
	 * @param  int  $amount
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function refund($amount = null)
	{
		// Prepare the payload
		$payload = array_filter(array_merge([
			'charge' => $this->charge->stripe_id,
		], compact('amount')));

		// Refunds the charge on Stripe
		$refund = $this->client->refunds()->create($payload);

		// Create the local refund entry
		$this->storeChargeRefund($this->charge, $refund);

		// Get the updated charge
		$response = $this->client->charges()->find($this->getPayload());

		// Update the charge on storage
		return $this->storeCharge($response);
	}

	/**
	 * Captures the charge.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function capture()
	{
		// Prepare the payload
		$payload = $this->getPayload();

		// Capture the charge on Stripe
		$response = $this->client->charges()->capture($payload);

		// Disable the event dispatcher
		$this->disableEventDispatcher();

		// Update the charge on storage
		$charge = $this->storeCharge($response);

		// Enable the event dispatcher
		$this->enableEventDispatcher();

		// Fire the 'cartalyst.stripe.charge.captured' event
		$this->fire('charge.captured', [ $response, $charge ]);

		return $charge;
	}

	/**
	 * Disables the charge from being captured.
	 *
	 * @return $this
	 */
	public function disableCapture()
	{
		$this->capture = false;

		return $this;
	}

	/**
	 * Sets the currency to be used upon a new charge.
	 *
	 * @param  string  $currency
	 * @return $this
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;

		return $this;
	}

	/**
	 * Sets the token that'll be used to create a new credit card.
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
	 * Syncronizes the Stripe charges data with the local data.
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

		// Get all the entity charges
		$charges = array_reverse($this->client->chargesIterator($payload)->toArray());

		// Loop through the charges
		foreach ($charges as $charge)
		{
			$this->storeCharge($charge);
		}
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
			'id' => $this->charge->stripe_id,
		]);
	}

	/**
	 * Stores the charge information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	protected function storeCharge($response)
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the charge id
		$stripeId = $response['id'];

		// Find the charge on storage
		$charge = $entity->charges()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $charge ? 'created' : 'updated';

		// Prepare the payload
		$payload = [
			'stripe_id'   => $stripeId,
			'invoice_id'  => $response['invoice'],
			'currency'    => $response['currency'],
			'description' => $response['description'],
			'amount'      => $this->convertToDecimal($response['amount']),
			'paid'        => (bool) $response['paid'],
			'captured'    => (bool) $response['captured'],
			'refunded'    => (bool) $response['refunded'],
			'failed'      => ($response['failure_message'] && $response['failure_code']),
			'created_at'  => $this->nullableTimestamp($response['created']),
		];

		// Does the charge exist on storage?
		if ( ! $charge)
		{
			$charge = $entity->charges()->create($payload);
		}
		else
		{
			$charge->update($payload);
		}

		// Fires the appropriate event
		$this->fire("charge.{$event}", [ $response, $charge ]);

		// Get all the refunds of this charge
		$refunds = $this->client->refundsIterator([
			'charge' => $stripeId,
		]);

		// Loop through the refunds
		foreach ($refunds as $refund)
		{
			$this->storeChargeRefund($charge, $refund);
		}

		return $charge;
	}

	/**
	 * Stores the charge refund information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Billing\Models\IlluminateCharge  $charge
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund
	 */
	protected function storeChargeRefund(IlluminateCharge $charge, $response)
	{
		// Get the refund id
		$stripeId = $response['id'];

		// Find the refund on storage
		$refund = $charge->refunds()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $refund ? 'created' : 'updated';

		// Prepare the payload
		$payload = [
			'stripe_id'  => $stripeId,
			'amount'     => $this->convertToDecimal($response['amount']),
			'currency'   => $response['currency'],
			'created_at' => $this->nullableTimestamp($response['created']),
		];

		// Does the refund exists on storage?
		if ( ! $refund)
		{
			$refund = $charge->refunds()->create($payload);
		}
		else
		{
			$refund->update($payload);
		}

		// Fires the appropriate event
		$this->fire("charge.refund.{$event}", [ $response, $refund ]);

		return $refund;
	}

}
