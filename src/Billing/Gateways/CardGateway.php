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
use Cartalyst\Stripe\Billing\BillableInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateCard;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CardGateway extends StripeGateway {

	/**
	 * The Eloquent card object.
	 *
	 * @var \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	protected $card;

	/**
	 * Flag for wether the credit card should be
	 * made the default credit card or not.
	 *
	 * @var bool
	 */
	protected $default = false;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Billing\BillableInterface  $billable
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
	 * Creates a new credit card on the entity.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	public function create($token, array $attributes = [])
	{
		// Get the entity object
		$entity = $this->billable;

		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		$customer = $this->findOrCreate(
			$entity->stripe_id,
			array_get($attributes, 'customer', [])
		);

		// Get the entity stripe id
		$stripeId = $entity->stripe_id;

		// Create the card on Stripe
		$response = $this->client->cards()->create(array_merge($attributes, [
			'card'     => $token,
			'customer' => $stripeId,
		]));

		// Fetch the Stripe customer again, so that we
		// have the customer with the most recent data.
		$customer = $this->client->customers()->find([
			'id' => $stripeId,
		]);

		// Is this the default credit card?
		$isDefault = ($this->default || $customer['default_card'] === $response['id']);

		// Should we make the card the default?
		if ($isDefault)
		{
			$this->client->customers()->update([
				'id'           => $stripeId,
				'default_card' => $response['id'],
			]);
		}

		// Attach the created card to the billable entity
		return $this->storeCard($response, $isDefault);
	}

	/**
	 * Updates the card.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	public function update(array $attributes = [])
	{
		// Prepare the payload
		$payload = $this->getPayload($attributes);

		// Update the card on Stripe
		$response = $this->client->cards()->update($payload);

		// Update the card on storage
		return $this->storeCard($response);
	}

	/**
	 * Deletes the card.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the card on Stripe
		$response = $this->client->cards()->destroy($this->getPayload());

		// Delete the card locally
		$this->card->delete();

		// Get the Stripe customer
		$customer = $this->client->customers()->find([
			'id' => $this->billable->stripe_id,
		]);

		// Update the default card on storage
		$this->updateDefaultLocalCard($customer['default_card']);

		// Fire the 'cartalyst.stripe.card.deleted' event
		$this->fire('card.deleted', [ $response ]);

		return true;
	}

	/**
	 * Make this credit card the default one after creation.
	 *
	 * @return $this
	 */
	public function makeDefault()
	{
		$this->default = true;

		return $this;
	}

	/**
	 * Sets the credit card as the default card.
	 *
	 * @return void
	 */
	public function setDefault()
	{
		// Update the customer
		$this->client->customers()->update([
			'id'           => $this->billable->stripe_id,
			'default_card' => $this->card->stripe_id,
		]);

		// Update the default card on storage
		$this->updateDefaultLocalCard($this->card->stripe_id);
	}

	/**
	 * Syncronizes the Stripe cards data with the local data.
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

		// Get the entity stripe customer object
		$customer = $this->client->customers()->find([
			'id' => $entity->stripe_id,
		]);

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

		// Get all the entity cards from Stripe
		$cards = $this->client->cardsIterator($payload);

		$stripeCards = [];

		foreach ($cards as $card)
		{
			$stripeCards[$card['id']] = $card;
		}

		// Loop through the current entity cards, this is to
		// make sure that non existing cards gets removed.
		foreach ($entity->cards as $card)
		{
			if ( ! array_get($stripeCards, $card->stripe_id))
			{
				$card->delete();
			}
		}

		// Hold the entity current default credit card
		$defaultCard = $customer['default_card'];

		// Loop through the credit cards
		foreach ($stripeCards as $card)
		{
			$this->storeCard($card, ($defaultCard === $card['id']), $callback);
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
			'id'       => $this->card->stripe_id,
			'customer' => $this->billable->stripe_id,
		]);
	}

	/**
	 * Updates the default card that is stored locally.
	 *
	 * @param  string  $id
	 * @return void
	 */
	protected function updateDefaultLocalCard($id)
	{
		$entity = $this->billable;

		$entity->cards()->where('default', true)->update(['default' => false]);

		$entity->cards()->where('stripe_id', $id)->update(['default' => true]);
	}

	/**
	 * Stores the card information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @param  bool  $default
	 * @param  \Closure  $callback
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	protected function storeCard($response, $default = false, Closure $callback = null)
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the card id
		$stripeId = $response['id'];

		// Find the card on storage
		$card = $entity->cards()->where('stripe_id', $stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $card ? 'created' : 'updated';

		// Prepare the payload
		$payload = [
			'stripe_id' => $stripeId,
			'brand'     => $response['brand'],
			'funding'   => $response['funding'],
			'cvc_check' => $response['cvc_check'],
			'last_four' => $response['last4'],
			'exp_month' => $response['exp_month'],
			'exp_year'  => $response['exp_year'],
		];

		// Does the card exist on storage?
		if ( ! $card)
		{
			$card = $entity->cards()->create($payload);
		}
		else
		{
			$card->update($payload);
		}

		// Should we make this card the default card?
		if ($default)
		{
			$this->updateDefaultLocalCard($stripeId);
		}

		if ($callback)
		{
			call_user_func($callback, $response, $card);
		}

		// Fire the appropriate event
		$this->fire("card.{$event}", [ $response, $card ]);

		return $card;
	}

}
