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
		'uri'           => '/v1/charges',
		'summary'       => 'Returns all the existing charges.',
		'responseModel' => 'Response',
		'parameters'    => [

			'limit' => [
				'description' => 'Limit of how many charges are retrieved.',
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

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'customer' => [
				'description' => 'Only return charges for a specific customer.',
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
		'uri'           => '/v1/charges/{id}',
		'summary'       => 'Returns an existing charge.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Charge unique identifier.',
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
		'uri'           => '/v1/charges',
		'summary'       => 'Create a new charge (either card or customer is needed)',
		'responseModel' => 'Response',
		'parameters'    => [

			'amount' => [
				'description' => 'Amount (in cents).',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => true,
			],

			'currency' => [
				'description' => '3-letter ISO code for currency.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'customer' => [
				'description' => 'Unique client identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'card' => [
				'description' => 'Unique card identifier (can either be an ID or a hash).',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'capture' => [
				'description' => 'Whether or not to immediately capture the charge.',
				'location'    => 'query',
				'type'        => 'string', #'boolean', <- Guzzle converts to 1/0
				'required'    => false,
			],

			'description' => [
				'description' => 'Charge description. (optional)',
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

			'statement_description' => [
				'description' => 'An arbitrary string to be displayed alongside your company name on your customer\'s credit card statement',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'receipt_email' => [
				'description' => 'The email address to send this charge\'s receipt to',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'application_fee' => [
				'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account',
				'location'    => 'query',
				'type'        => 'integer',
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

	'update' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/charges/{id}',
		'summary'       => 'Updates an existing charge.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Charge unique identifier. to update',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'Charge description. (optional)',
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

	'capture' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/charges/{id}/capture',
		'summary'       => 'Captures an existing charge.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'Amount (in cents) to capture.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'receipt_email' => [
				'description' => 'The email address to send this charge\'s receipt to.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'application_fee' => [
				'description' => 'A fee in cents that will be applied to the charge and transferred to the application owner\'s Stripe account.',
				'location'    => 'query',
				'type'        => 'integer',
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

	'refund' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/charges/{id}/refund',
		'summary'       => 'Refunds an existing charge.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'Amount (in cents), it defaults to the whole charge if not provided.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'refund_application_fee' => [
				'description' => 'Indicate whether the application fee should be refunded when refunding this charge.',
				'location'    => 'query',
				'type'        => 'string', #'boolean', <- Guzzle converts to 1/0
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
