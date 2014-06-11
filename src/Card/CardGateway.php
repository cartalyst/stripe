<?php namespace Cartalyst\Stripe\Card;
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

use Cartalyst\Stripe\BillableInterface;
use Cartalyst\Stripe\StripeGateway;

class CardGateway extends StripeGateway {

	/**
	 * The card object.
	 *
	 * @var \Cartalyst\Stripe\Card\IlluminateCard
	 */
	protected $card;

	/**
	 * Flag for wether the credit card should be made
	 * the default credit card.
	 *
	 * @var bool
	 */
	protected $default = false;

	/**
	 * Create a new Stripe Card gateway instance.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @param  mixed  $card
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $card = null)
	{
		parent::__construct($billable);

		if (is_numeric($card))
		{
			$card = $this->billable->cards->find($card);
		}

		if ($card instanceof IlluminateCard)
		{
			$this->card = $card;
		}
	}

	/**
	 * Returns the Stripe card object.
	 *
	 * @return \Stripe_Card
	 */
	public function get()
	{
		return $this
				->getStripeCustomer()
				->cards
				->retrieve($this->card->stripe_id);
	}

	/**
	 * Creates a new credit card.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return \Stripe_Card
	 */
	public function create($token, array $attributes = [])
	{
		if ($id = $this->billable->getStripeId())
		{
			$customer = $this->updateStripeCustomer($id, array_get($attributes, 'customer', []));

			$card = $customer->cards->create(['card' => $token]);

			if ($this->default)
			{
				$customer->default_card = $card->id;
				$customer->save();
			}

			$attributes = array_merge($attributes, [
				'stripe_id' => $card->id,
				'last_four' => $card->last4,
				'exp_month' => $card->exp_month,
				'exp_year'  => $card->exp_year,
			]);

			array_forget($attributes, 'customer');

			$this->billable->cards()->create($attributes);
		}
		else
		{
			$customer = $this->createStripeCustomer($token, array_get($attributes, 'customer', []));
		}

		$this->updateLocalStripeData($this->getStripeCustomer($customer->id));

		//return $card;
	}

	/**
	 * Updates the card.
	 *
	 * @param  array  $attributes
	 * @return \Stripe_Card
	 */
	public function update(array $attributes = [])
	{
		$card = $this->get();

		foreach ($attributes as $key => $value)
		{
			$card->{$key} = $value;
		}

		$card->save();

		return $card;
	}

	/**
	 * Delete the card.
	 *
	 * @return void
	 */
	public function delete()
	{
		$this->get()->delete();

		$this->card->delete();

		$this->updateLocalStripeData($this->getStripeCustomer());
	}

	/**
	 * Specify that the credit card should be the default one.
	 *
	 * @return void
	 */
	public function makeDefault()
	{
		$this->default = true;

		return $this;
	}

	/**
	 * Sets the credit card as the default one.
	 *
	 * @return void
	 */
	public function setDefault()
	{
		$customer = $this->getStripeCustomer();

		$customer->default_card = $this->get()->id;

		$customer->save();

		$this->updateLocalStripeData($this->getStripeCustomer($customer->id));
	}

	/**
	 * Syncronizes the Stripe cards data with the local data.
	 *
	 * @return void
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		$customer = $this->getStripeCustomer();

		$defaultCard = $customer->default_card;

		foreach ($customer->cards->data as $card)
		{
			$stripeId = $card->id;

			$_card = $entity->cards()->where('stripe_id', $stripeId)->first();

			$data = [
				'stripe_id' => $stripeId,
				'last_our'  => $card->last4,
				'exp_month' => $card->exp_month,
				'exp_year'  => $card->exp_year,
				'default'   => $defaultCard === $stripeId ? true : false,
			];

			if ( ! $_card)
			{
				$entity->cards()->create($data);
			}
			else
			{
				$_card->update($data);
			}
		}
	}

}
