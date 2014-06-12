<?php namespace Cartalyst\Stripe;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient {

	/**
	 * Constructor.
	 *
	 * @param  string  $stripeKey
	 * @param  string  $url
	 * @param  string  $version
	 * @return void
	 */
	public function __construct($stripeKey, $url = 'https://api.stripe.com', $version = 'v1')
	{
		$baseUrl = "{$url}/{$version}";

		$config = [
			'base_url' => "{$baseUrl}/",
			'defaults' => [
				'auth' =>  [
					$stripeKey, null,
				],
			],
		];

		parent::__construct($config);
	}

}
