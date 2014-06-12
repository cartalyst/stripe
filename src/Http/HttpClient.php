<?php namespace Cartalyst\Stripe\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Event\BeforeEvent;

class HttpClient extends Client {

	/**
	 * Default Client options.
	 *
	 * @var array
	 */
	protected $options = [
		'base_url'   => [
			'https://api.stripe.com/{version}/', [
				'version' => 'v1',
			],
		],
		'user_agent' => 'cartalyst-stripe-api (Cartalyst.com)',
	];

	public function __construct(array $options = [])
	{
		$options = array_merge($this->options, $options);

		parent::__construct($options);
	}

}
