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
		'summary'       => 'Returns all the cards of an existing customer.',
		'responseModel' => 'Response',
		'parameters'    => [

			'customer' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'limit' => [
				'description' => 'Limit of how many cards are retrieved.',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'starting_after' => [
				'description' => 'A cursor to be used in the pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'ending_before' => [
				'description' => 'A cursor to be used in the pagination.',
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

			'include' => [
				'description' => 'Allows to include some additional properties.',
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
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'customer' => [
				'description' => 'Customer unique identifier.',
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

	'create' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/customers/{customer}/cards',
		'summary'       => 'Creates a new card on an existing customer.',
		'responseModel' => 'Response',
		'parameters'    => [

			'customer' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'card' => [
				'description' => 'Unique card identifier.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
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

	'delete' => [

		'httpMethod'    => 'DELETE',
		'uri'           => '/v1/customers/{customer}/cards/{id}',
		'summary'       => 'Deletes an existing customer card.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'customer' => [
				'description' => 'Customer unique identifier.',
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

	'update' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/customers/{customer}/cards/{id}',
		'summary'       => 'Updates an existing customer card.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Card unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'customer' => [
				'description' => 'Customer unique identifier.',
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
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'exp_year' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
			],

			'name' => [
				'location' => 'query',
				'type'     => 'string',
				'required' => false,
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
