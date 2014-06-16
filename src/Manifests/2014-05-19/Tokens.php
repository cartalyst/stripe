<?php
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

return [

	'create' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/tokens',
		'summary'       => 'Creates a new token.',
		'responseModel' => 'Response',
		'parameters'    => [

			'bank_account' => [
				'description' => 'A bank account to attach to the recipient.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be a token or an array)',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'customer' => [
				'description' => 'A customer to create a token for.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allows to expand some properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'find' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/tokens/{id}',
		'summary'       => 'Returns details about an existing token.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Token unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allows to expand some properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
