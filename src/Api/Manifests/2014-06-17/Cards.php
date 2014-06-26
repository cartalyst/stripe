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

	'all' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/customers/{customer}/cards',
		'summary'       => 'Returns a list of cards that belongs to the given customer.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'ending_before' => [
				'description' => 'A cursor to be used in pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'limit' => [
				'description' => 'A limit on the number of objects to be returned. Limit can range between 1 and 100 items.',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'starting_after' => [
				'description' => 'A cursor to be used in pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'include' => [
				'description' => 'Allows to include additional properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'find' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/customers/{customer}/cards/{id}',
		'summary'       => 'Returns a card from an existing customer.',
		'summary'       => 'Retrieves the details of a card that belongs to the given customer.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'create' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/customers/{customer}/cards',
		'summary'       => 'Creates a new card on the given customer.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'card' => [
				'description' => 'The card unique identifier.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'delete' => [

		'httpMethod'    => 'DELETE',
		'uri'           => '/v1/customers/{customer}/cards/{id}',
		'summary'       => 'Deletes a card from the given customer.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'update' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/customers/{customer}/cards/{id}',
		'summary'       => 'Updates a card from the given customer.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'address_city' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'address_country' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'address_line1' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'address_line2' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'address_state' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'address_zip' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'exp_month' => [
				'description' => 'Two digit number representing the card\'s expiration month.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'exp_year' => [
				'description' => 'Two or four digit number representing the card\'s expiration year.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'name' => [
				'description' => 'Cardholder\'s full name.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
