<?php namespace Cartalyst\Stripe;

class StripeCustomer extends Stripe {

	public function __construct(Client $client)
	{
		parent::__construct($client);
	}

	public function all()
	{
		return $this->client->get('customers')->json();
	}

}
