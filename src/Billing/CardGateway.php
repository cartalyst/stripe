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
	 * @return \Cartalyst\Stripe\Api\Response
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
		$card = $this->client->cards()->create(array_merge($attributes, [
			'card'     => $token,
			'customer' => $stripeId,
		]));

		// Get the Stripe customer
		$customer = $this->client->customers()->find([
			'id' => $stripeId,
		]);

		// Is this the default credit card?
		$isDefault = ($this->default || $customer['default_card'] === $card['id']);

		// Attach the created card to the billable entity
		$model = $this->storeCard($card, $isDefault);

		// Fire the 'cartalyst.stripe.card.created' event
		$this->fire('card.created', [ $card, $model ]);

		return $card;
	}

	/**
	 * Updates the card.
	 *
	 * @param  array  $attributes
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function update(array $attributes = [])
	{
		// Prepare the payload
		$payload = $this->getPayload($attributes);

		// Update the card on Stripe
		$card = $this->client->cards()->update($payload);

		// Update the card on storage
		$model = $this->storeCard($card);

		// Fire the 'cartalyst.stripe.card.updated' event
		$this->fire('card.updated', [ $card, $model ]);

		return $card;
	}

	/**
	 * Deletes the card.
	 *
	 * @return \Cartalyst\Stripe\Api\Response
	 */
	public function delete()
	{
		// Delete the card on Stripe
		$card = $this->client->cards()->delete($this->getPayload());

		// Delete the card locally
		$this->card->delete();

		// Get the Stripe customer
		$customer = $this->client->customers()->find([
			'id' => $this->billable->stripe_id,
		]);

		$this->updateDefaultLocalCard($customer['default_card']);

		// Fire the 'cartalyst.stripe.card.deleted' event
		$this->fire('card.deleted', [ $card ]);

		return $card;
	}

	/**
	 * Make this credit card the default one after creation.
	 *
	 * @return \Cartalyst\Stripe\Billing\CardGateway
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
		$this->client->customers()->update([
			'id'           => $this->billable->stripe_id,
			'default_card' => $this->card->stripe_id,
		]);

		$this->updateDefaultLocalCard($this->card->stripe_id);
	}

	/**
	 * Syncronizes the Stripe cards data with the local data.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe()
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

		// Get all the entity cards
		$cards = $this->client->cardsIterator([
			'customer' => $entity->stripe_id,
		]);

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
			$isDefault = $defaultCard === $card['id'] ? true : false;

			$this->storeCard($card, $isDefault);
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
	 * @param  int  $id
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
	 * @param  \Cartalyst\Stripe\Api\Response  $card
	 * @param  bool  $default
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCard
	 */
	protected function storeCard($card, $default = false)
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the card id
		$stripeId = $card['id'];

		// Find the card on storage
		$_card = $entity->cards()->where('stripe_id', $stripeId)->first();

		// Prepare the payload
		$payload = [
			'stripe_id' => $stripeId,
			'last_four' => $card['last4'],
			'exp_month' => $card['exp_month'],
			'exp_year'  => $card['exp_year'],
		];

		// Does the card exist on storage?
		if ( ! $_card)
		{
			$_card = $entity->cards()->create($payload);
		}
		else
		{
			$_card->update($payload);
		}

		// Should we make this card the default card?
		if ($default)
		{
			$entity->cards()->where('default', true)->update(['default' => false]);

			$entity->cards()->where('stripe_id', $stripeId)->update(['default' => true]);
		}

		return $_card;
	}

}
