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
use Cartalyst\Stripe\BillableInterface;
use Cartalyst\Stripe\Models\IlluminateCard;

class CardGateway extends AbstractGateway {

	/**
	 * The Eloquent card object.
	 *
	 * @var \Cartalyst\Stripe\Models\IlluminateCard
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
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @param  mixed  $id
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $id = null)
	{
		parent::__construct($billable);

		$card = $this->billable->cards()->getModel()->find($id);

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
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	public function create($token, array $attributes = [])
	{
		// Find or Create the Stripe customer that
		// will belong to this billable entity.
		#(new CustomerGateway($this->billable))->findOrCreate(
		$this->billable->findOrCreateStripeCustomer(
			array_pull($attributes, 'customer', [])
		);

		// Get the entity stripe id
		$stripeId = $this->billable->stripe_id;

		// Create the card on Stripe
		$response = $this->client->cards()->create([
			'card'     => $token,
			'customer' => $stripeId,
		]);

		// Fetch the Stripe customer again, so that we
		// have the customer with the most recent data.
		$customer = $this->client->customers()->find([ 'id' => $stripeId ]);

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
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	public function update(array $attributes = [])
	{
		// Check if a valid card was selected
		$this->checkCardIsValid();

		// Update the card on Stripe
		$response = $this->client->cards()->update(
			$this->getPayload($attributes)
		);

		// Should we make the card the default?
		if ($this->default)
		{
			$this->client->customers()->update([
				'id'           => $this->billable->stripe_id,
				'default_card' => $response['id'],
			]);
		}

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
		// Check if a valid card was selected
		$this->checkCardIsValid();

		// Delete the card on Stripe
		$response = $this->client->cards()->destroy(
			$this->getPayload()
		);

		// Delete the card from storage
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
	 * Make this credit card the default after creating or updating the card.
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
		// Check if a valid card was selected
		$this->checkCardIsValid();

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
		// Check if the entity is a stripe customer
		$this->checkEntityIsBillable();

		// Get the entity stripe customer object
		$customer = $this->client->customers()->find([
			'id' => $this->billable->stripe_id,
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
			'customer' => $this->billable->stripe_id,
		]);

		// Remove the "callback" from the arguments, this is passed
		// through the main syncWithStripe method, so we remove it
		// here anyways so that we can have a proper payload.
		$callback = array_pull($payload, 'callback', $callback);

		// Get all the entity cards from Stripe
		$cards = $this->client->cardsIterator($payload);

		// Determine the credit cards that needs to be removed
		$cardsToDelete = array_diff(
			$this->billable->cards->lists('stripe_id'),
			array_pluck($cards->toArray(), 'id')
		);

		// Loop through the credit cards
		foreach ($cards as $card)
		{
			$this->storeCard($card, ($customer['default_card'] === $card['id']), $callback);
		}

		// Delete the old cards
		foreach ($cardsToDelete as $id)
		{
			$this->billable->cards()->whereStripeId($id)->first()->delete();
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

		$entity->cards()->whereStripeId($id)->update(['default' => true]);
	}

	/**
	 * Stores the card information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @param  bool  $default
	 * @param  \Closure  $callback
	 * @return \Cartalyst\Stripe\Models\IlluminateCard
	 */
	protected function storeCard($response, $default = false, Closure $callback = null)
	{
		// Get the card id
		$stripeId = $response['id'];

		// Find the card on storage
		$card = $this->billable->cards()->whereStripeId($stripeId)->first();

		// Flag to know which event needs to be fired
		$event = ! $card ? 'created' : 'updated';

		// Prepare the payload
		$payload = [
			'stripe_id'   => $stripeId,
			'brand'       => $response['brand'],
			'funding'     => $response['funding'],
			'cvc_check'   => $response['cvc_check'],
			'last_four'   => $response['last4'],
			'exp_month'   => $response['exp_month'],
			'exp_year'    => $response['exp_year'],
			'fingerprint' => $response['fingerprint'],
		];

		// Does the card exist on storage?
		if ( ! $card)
		{
			$model = $this->billable->getCardModel();

			$card = $this->billable->cards()->save(
				new $model($payload)
			);
		}
		else
		{
			$card->update($payload);
		}

		// Should we make this card the default card?
		if ($default) $this->updateDefaultLocalCard($stripeId);

		// Handle the callback
		$this->handleCallback($callback, $response, $card);

		// Fire the appropriate event
		$this->fire("card.{$event}", [ $response, $card ]);

		return $card;
	}

	/**
	 * Checks if a valid card was selected.
	 *
	 * @return void
	 * @throws \RuntimeException
	 */
	protected function checkCardIsValid()
	{
		if ( ! $this->card)
		{
			$method = debug_backtrace()[1]['function'];

			throw new \RuntimeException(
				"Calling the '{$method}' method on an invalid or non existing card is not allowed!"
			);
		}
	}

}
