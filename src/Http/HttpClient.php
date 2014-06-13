<?php namespace Cartalyst\Stripe\Http;
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

	/**
	 * Constructor.
	 *
	 * @param  array  $options
	 * @return void
	 */
	public function __construct(array $options = [])
	{
		$options = array_merge($this->options, $options);

		parent::__construct($options);
	}

}
