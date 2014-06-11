<?php namespace Cartalyst\Stripe;

class Stripe {

	/**
	 * The Guzzle client.
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	protected $billable;

	public function __construct($billable)
	{
		$this->billable;
	}

	public function client()
	{
		if ( ! $this->client)
		{
			$this->client = new StripeClient($this->billable->getStripeKey());
		}

		return $this->client;
	}


}
