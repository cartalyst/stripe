<?php namespace Cartalyst\Stripe;
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
use Cartalyst\Stripe\Models\IlluminateCard;

class CardGateway extends StripeGateway {

	/**
	 * The card object.
	 *
	 * @var \Cartalyst\Stripe\Models\IlluminateCard
	 */
	protected $card;

	/**
	 * Flag for wether the credit card should
	 * be made the default credit card.
	 *
	 * @var bool
	 */
	protected $default = false;

	/**
	 * Constructor.
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
	 * Creates a new credit card on the entity.
	 *
	 * @param  string  $token
	 * @param  array  $attributes
	 * @return array
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
		$entity->cards()->create([
			'stripe_id' => $card['id'],
			'last_four' => $card['last4'],
			'exp_month' => $card['exp_month'],
			'exp_year'  => $card['exp_year'],
			'default'   => $isDefault,
		]);

		// Should we make this card the default one?
		if ($isDefault)
		{
			$this->updateDefaultLocalCard($card['id']);
		}

		return $card;
	}

	/**
	 * Updates the card.
	 *
	 * @param  array  $attributes
	 * @return array
	 */
	public function update(array $attributes = [])
	{
		$payload = $this->getPayload($attributes);

		return $this->client->cards()->update($payload);
	}

	/**
	 * Deletes the card.
	 *
	 * @return array
	 */
	public function delete()
	{
		// Get the entity object
		$entity = $this->billable;

		// Get the request payload
		$payload = $this->getPayload();

		// Delete the card on Stripe
		$card = $this->client->cards()->delete($payload);

		// Delete the card locally
		$this->card->delete();

		// Get the Stripe customer
		$customer = $this->client->customers()->find([
			'id' => $entity->stripe_id,
		]);

		$this->updateDefaultLocalCard($customer['default_card']);

		return $card;
	}

	/**
	 * Make this credit card the default one after creation.
	 *
	 * @return \Cartalyst\Stripe\CardGateway
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
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		$customer = $this->client->customers()->find([
			'id' => $entity->stripe_id,
		]);

		$cards = $this->client->cards()->all([
			'customer' => $entity->stripe_id,
		]);

		$defaultCard = $customer['default_card'];

		foreach ($cards['data'] as $card)
		{
			$stripeId = $card['id'];

			$_card = $entity->cards()->where('stripe_id', $stripeId)->first();

			$data = [
				'stripe_id' => $stripeId,
				'last_our'  => $card['last4'],
				'exp_month' => $card['exp_month'],
				'exp_year'  => $card['exp_year'],
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

		$entity->cards()
			->where('default', true)
			->update(['default' => false]);

		$entity->cards()
			->where('stripe_id', $id)
			->update(['default' => true]);
	}

}
