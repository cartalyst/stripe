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

		'httpMethod'     => 'GET',
		'uri'            => '/v1/customers',
		'summary'        => 'Retrieves all the existing customers.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

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

			'ending_before' => [
				'description' => 'A cursor to be used in pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allows to expand properties.',
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

		'httpMethod'     => 'GET',
		'uri'            => '/v1/customers/{id}',
		'summary'        => 'Retrieves an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
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

		'httpMethod'     => 'POST',
		'uri'            => '/v1/customers',
		'summary'        => 'Creates a new customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'account_balance' => [
				'description' => 'An integer amount in cents that is the starting account balance for your customer.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash).',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'coupon' => [
				'description' => 'Coupon identifier that applies a discount on all recurring charges. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'plan' => [
				'description' => 'Plan for the customer. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'quantity' => [
				'description' => 'Quantity you\'d like to apply to the subscription you\'re creating.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'trial_end' => [
				'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'description' => [
				'description' => 'Customer description. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'email' => [
				'description' => 'Customer email address. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'Metadata. (optional)',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allows to expand some properties',
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
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allows to expand some properties',
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
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'account_balance' => [
				'description' => 'An integer amount in cents that is the starting account balance for your customer.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash).',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'default_card' => [
				'description' => 'Default card identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'coupon' => [
				'description' => 'Coupon identifier that applies a discount on all recurring charges. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'description' => [
				'description' => 'Customer description. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'email' => [
				'description' => 'Customer email address. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'Metadata. (optional)',
				'location'    => 'query',
				'type'        => 'array',
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

	'deleteDiscount' =>	[

		'httpMethod'     => 'DELETE',
		'uri'            => '/v1/customers/{id}/discount',
		'summary'        => 'Deletes an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'Customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

		],

	],

];
