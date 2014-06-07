<?php namespace Cartalyst\Stripe\Charge;
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
use Stripe_Charge;

class ChargeGateway extends StripeGateway {

	/**
	 * The charge object.
	 *
	 * @var \Cartalyst\Stripe\Relations\Charge
	 */
	protected $charge;

	/**
	 * Flag to wether capture the charge or not.
	 *
	 * @var bool
	 */
	protected $capture = true;

	/**
	 * The charge currency.
	 *
	 * @var string
	 */
	protected $currency = 'usd';

	/**
	 * The token for the new credit card.
	 *
	 * @var string
	 */
	protected $token = null;

	/**
	 * Create a new Stripe Charge gateway instance.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
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
	 * Returns the Stripe charge object.
	 *
	 * @return \Stripe_Card
	 */
	public function get()
	{
		return Stripe_Charge::retrieve($this->charge->stripe_id);
	}

	/**
	 * Creates a new charge.
	 *
	 * @param  int  $amount
	 * @param  array  $attributes
	 * @return void
	 */
	public function create($amount, array $attributes = [])
	{
		if ( ! $this->billable->getStripeId())
		{
			$customer = $this->createStripeCustomer($this->token, array_get($attributes, 'customer', []));

			$this->updateLocalStripeData($this->getStripeCustomer($customer->id));

			$this->token = $customer->default_card;
		}
		else
		{
			$customer = $this->getStripeCustomer();

			if ($this->token)
			{
				$card = $this->billable->card()->create($this->token);

				$this->token = $card->id;
			}
		}

		$preparedAmount = $this->prepareAmount($amount);

		$attributes = array_merge($attributes, [
			'customer' => $customer->id,
			'capture'  => $this->capture,
			'currency' => $this->currency,
			'amount'   => $preparedAmount,
			'card'     => $this->token,
		]);

		$charge = Stripe_Charge::create($attributes);

		$this->billable->charges()->create([
			'stripe_id'   => $charge->id,
			'amount'      => $preparedAmount,
			'captured'    => $charge->captured,
			'refunded'    => $charge->refunded,
			'description' => array_get($attributes, 'description', null),
		]);
	}

	/**
	 * Updates a charge.
	 *
	 * @param  string  $description
	 * @param  array  $metadata
	 * @return void
	 */
	public function update($description, array $metadata = [])
	{
		$charge = $this->get();
		$charge->description = $description;
		$charge->metadata = $metadata;
		$charge->save();
	}

	/**
	 * Refunds a charge.
	 *
	 * @param  int  $amount
	 * @return void
	 */
	public function refund($amount = null)
	{
		$preparedAmount = $this->prepareAmount($amount);

		$refund = $this->get()->refund([
			'amount' => $preparedAmount,
		]);

		$this->charge->update([
			'refunded' => $refund->refunded,
		]);

		$this
			->charge
			->refunds()
			->create([
				'amount' => $preparedAmount,
			]);
	}

	/**
	 * Captures a charge.
	 *
	 * @return void
	 */
	public function capture()
	{
		$this->get()->capture();

		$this->charge->update(['captured' => true]);
	}

	/**
	 * Disables the charge from being captured.
	 *
	 * @return \Cartalyst\Stripe\Charge\ChargeGateway
	 */
	public function disableCapture()
	{
		$this->capture = false;

		return $this;
	}

	/**
	 * Sets the currency.
	 *
	 * @param  string  $currency
	 * @return \Cartalyst\Stripe\Charge\ChargeGateway
	 */
	public function setCurrency($currency)
	{
		$this->currency = $currency;

		return $this;
	}

	/**
	 * Sets the token.
	 *
	 * @param  string  $token
	 * @return \Cartalyst\Stripe\Charge\ChargeGateway
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
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		$customer = $this->getStripeCustomer();

		$charges = Stripe_Charge::all([
			'customer' => $customer->id
		]);

		foreach ($charges->data as $charge)
		{
			$stripeId = $charge->id;

			$_charge = $entity->charges()->where('stripe_id', $stripeId)->first();

			$data = [
				'stripe_id'   => $stripeId,
				'description' => $charge->description,
				'amount'      => $charge->amount,
				'captured'    => $charge->captured,
				'refunded'    => $charge->refunded,
				'created_at'  => Carbon::createFromTimestamp($charge->created),
			];

			if ( ! $_charge)
			{
				$entity->charges()->create($data);
			}
			else
			{
				$_charge->update($data);
			}

			# will need to save the charge refunds as well
		}
	}

	/**
	 * Converts the amount to cents.
	 *
	 * @param  int  $amount
	 * @return float
	 */
	protected function prepareAmount($amount)
	{
		return $amount * 100;
	}

}
