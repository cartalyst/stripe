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

	'find' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/customers/{id}',
		'summary'        => 'Retrieves an existing customer.',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'all' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/customers',
		'summary'        => 'Retrieves all the existing customers.',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'limit' => [
				'description' => 'Limit on how many customers are retrieved',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'starting_after' => [
				'description' => 'A cursor for use in the pagination',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'ending_before' => [
				'description' => 'A cursor for use in the pagination',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'include' => [
				'description' => 'Allow to include some additional properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'create' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/customers',
		'summary'        => 'Creates a new customer.',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'account_balance' => [
				'description' => 'An integer amount in cents that is the starting account balance for your customer',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash)',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'coupon' => [
				'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'plan' => [
				'description' => 'Optional plan for the customer',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'quantity' => [
				'description' => 'Quantity you\'d like to apply to the subscription you\'re creating',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'trial_end' => [
				'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'description' => [
				'description' => 'Optional description for the customer',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'email' => [
				'description' => 'Optional customer\'s email address',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'Optional metadata',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'delete' => [

		'httpMethod'     => 'DELETE',
		'uri'            => '/v1/customers/{id}',
		'summary'        => 'Deletes an existing customer.',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'update' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/customers/{id}',
		'summary'        => 'Updates an existing customer.',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'account_balance' => [
				'description' => 'An integer amount in cents that is the starting account balance for your customer',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash)',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'default_card' => [
				'description' => 'Default card identifier',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'coupon' => [
				'description' => 'Optional coupon identifier that applies a discount on all recurring charges',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'description' => [
				'description' => 'Optional description for the customer',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'email' => [
				'description' => 'Optional customer\'s email address',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'Optional metadata',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
