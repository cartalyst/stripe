<?php namespace Cartalyst\Stripe;

class Stripe {

	/**
	 * The Guzzle client.
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * The Stripe key.
	 *
	 * @var string
	 */
	protected $stripeKey;

	public function __construct(Client $client)
	{
		$this->client = $client;;
	}

	public function getClient()
	{
		return $this->client;
	}

	public function customers()
	{
		return new StripeCustomer($this->getClient());
	}

}
