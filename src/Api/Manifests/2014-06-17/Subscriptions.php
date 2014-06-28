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
		'uri'            => '/v1/customers/{customer}/subscriptions',
		'summary'        => 'Returns all the active subscriptions of an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

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
				'description' => 'Allow to include additional properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'find' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/customers/{customer}/subscriptions/{id}',
		'summary'        => 'Returns a subscription from an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The subscription unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'customer' => [
				'description' => 'The customer unique identifier.',
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
		'uri'            => '/v1/customers/{customer}/subscriptions',
		'summary'        => 'Creates a new subscription on an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'plan' => [
				'description' => 'The plan unique identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'coupon' => [
				'description' => 'Optional coupon identifier that applies a discount to the subscription.',
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

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash)',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'quantity' => [
				'description' => 'Quantity you\'d like to apply to the subscription.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'application_fee_percent' => [
				'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a charge object.',
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

	'cancel' => [

		'httpMethod'     => 'DELETE',
		'uri'            => '/v1/customers/{customer}/subscriptions/{id}',
		'summary'        => 'Deletes an existing customer subscription.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The subscription unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'at_period_end' => [
				'description' => 'A flag that if set to true, will delay the cancellation of the subscription until the end of the current period.',
				'location'    => 'query',
				'type'        => 'boolean',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Boolean::convert',
				],
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

		'httpMethod'     => 'POST',
		'uri'            => '/v1/customers/{customer}/subscriptions/{id}',
		'summary'        => 'Updates an existing customer subscription.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The subscription unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'plan' => [
				'description' => 'The plan unique identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'coupon' => [
				'description' => 'Optional coupon identifier that applies a discount to the subscription.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'prorate' => [
				'description' => 'Flag telling us whether to prorate switching plans during a billing cycle.',
				'location'    => 'query',
				'type'        => 'boolean',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Boolean::convert',
				],
			],

			'trial_end' => [
				'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'quantity' => [
				'description' => 'Quantity you\'d like to apply to the subscription.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'application_fee_percent' => [
				'description' => 'A positive decimal (with at most two decimal places) between 1 and 100 that represents the percentage of the subscription invoice amount due each billing period that will be transferred to the application owner’s Stripe account.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a charge object.',
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
		'uri'            => '/v1/customers/{customer}/subscriptions/{id}/discount',
		'summary'        => 'Deletes an existing customer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'customer' => [
				'description' => 'The customer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The subscription unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

		],

	],

];
