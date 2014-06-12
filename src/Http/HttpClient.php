<?php namespace Cartalyst\Stripe\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClient extends Client {

	protected $options = [
		'base_url'   => 'https://api.stripe.com/',
		'version'    => 'v1',
		'user_agent' => 'cartalyst-stripe-api (Cartalyst.com)',
	];

	public function __construct(array $options = [], ClientInterface $client = null)
	{
		$url = $this->options['base_url'];

		$version = $this->options['version'];

		$baseUrl = "{$url}/{$version}";

		//$stripeKey = \Config::get('services.stripe.secret');

		$config = [
			'base_url' => "{$baseUrl}/",
			// 'defaults' => [
			// 	'auth' =>  [
			// 		$stripeKey, null,
			// 	],
			// ],
		];

		parent::__construct($config);
	}

}
