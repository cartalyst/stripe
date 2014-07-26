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
use Cartalyst\Stripe\Billing\BillableInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateCharge;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ChargeGateway extends StripeGateway {

	/**
	 * The charge object.
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
	 * @return \Cartalyst\Stripe\Api\Response
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

			$card = $card['id'];
		}

		// Prepare the payload
		$attributes = array_merge($attributes, [
			'customer' => $entity->stripe_id,
			'capture'  => $this->capture,
			'currency' => $this->currency,
			'amount'   => $amount,
			'card'     => $card,
		]);

		// Create the charge on Stripe
		$charge = $this->client->charges()->create($attributes);

		// Attach the created charge to the billable entity
		$this->billable->charges()->create([
			'stripe_id'   => $charge['id'],
			'amount'      => $this->convertToDecimal($charge['amount']),
			'paid'        => $charge['paid'],
			'captured'    => $charge['captured'],
			'refunded'    => $charge['refunded'],
			'description' => array_get($attributes, 'description', null),
		]);

		// Fire the 'cartalyst.stripe.charge.created' event
		$this->fire('charge.created', [
			$entity,
			$charge,
		]);

		return $charge;
	}

	/**
	 * Updates the charge.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function update(array $attributes = [])
	{
		$payload = $this->getPayload($attributes);

		$charge = $this->client->charges()->update($payload);

		// Fire the 'cartalyst.stripe.charge.updated' event
		$this->fire('charge.updated', [
			$this->billable,
			$charge,
		]);

		return $charge;
	}

	/**
	 * Refunds the charge.
	 *
	 * @param  int  $amount
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function refund($amount = null)
	{
		// Prepare the payload
		$payload = $this->getPayload(array_filter(compact('amount')));

		// Refunds the charge on Stripe
		$refund = $this->client->charges()->refund($payload);

		// Create the local refund entry
		$this
			->charge
			->refunds()
			->create([
				'transaction_id' => $refund['balance_transaction'],
				'amount'         => $this->convertToDecimal($refund['amount']),
			]);

		// Get the updated charge
		$charge = $this->client->charges()->find($this->getPayload());

		// Update the local charge entry
		$this->charge->update([
			'refunded' => $charge['refunded'],
		]);

		// Fire the 'cartalyst.stripe.charge.refunded' event
		$this->fire('charge.refunded', [
			$this->billable,
			$charge,
		]);

		return $charge;
	}

	/**
	 * Captures the charge.
	 *
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function capture()
	{
		$payload = $this->getPayload();

		$charge = $this->client->charges()->capture($payload);

		// Fire the 'cartalyst.stripe.charge.captured' event
		$this->fire('charge.captured', [
			$this->billable,
			$charge,
		]);

		return $charge;
	}

	/**
	 * Disables the charge from being captured.
	 *
	 * @return \Cartalyst\Stripe\Billing\ChargeGateway
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
	 * @return \Cartalyst\Stripe\Billing\ChargeGateway
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
	 * @return \Cartalyst\Stripe\Billing\ChargeGateway
	 */
	public function setToken($token)
	{
		$this->token = $token;

		return $this;
	}

	/**
	 * Syncronizes the Stripe charges data with the local data.
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

		$charges = array_reverse($this->client->chargesIterator([
			'customer' => $entity->stripe_id,
		])->toArray());

		foreach ($charges as $charge)
		{
			$stripeId = $charge['id'];

			$_charge = $entity->charges()->where('stripe_id', $stripeId)->first();

			$data = [
				'stripe_id'   => $stripeId,
				'invoice_id'  => $charge['invoice'],
				'currency'    => $charge['currency'],
				'description' => $charge['description'],
				'amount'      => $this->convertToDecimal($charge['amount']),
				'paid'        => (bool) $charge['paid'],
				'captured'    => (bool) $charge['captured'],
				'refunded'    => (bool) $charge['refunded'],
				'created_at'  => Carbon::createFromTimestamp($charge['created']),
			];

			if ( ! $_charge)
			{
				$_charge = $entity->charges()->create($data);
			}
			else
			{
				$_charge->update($data);
			}

			$refunds = $this->client->refundsIterator([
				'charge' => $stripeId,
			]);

			foreach ($refunds as $refund)
			{
				$transactionId = $refund['balance_transaction'];

				$_refund = $_charge->refunds()->where('transaction_id', $transactionId)->first();

				$data = [
					'transaction_id' => $transactionId,
					'amount'         => $this->convertToDecimal($refund['amount']),
					'currency'       => $refund['currency'],
					'created_at'     => Carbon::createFromTimestamp($refund['created']),
				];

				if ( ! $_refund)
				{
					$_charge->refunds()->create($data);
				}
				else
				{
					$_refund->update($data);
				}
			}
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

}
