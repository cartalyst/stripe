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
		'uri'            => '/v1/charges',
		'summary'        => 'Returns a list of charges that were previously created.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'customer' => [
				'description' => 'Only return charges for the customer specified by this customer ID.',
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

		'httpMethod'     => 'GET',
		'uri'            => '/v1/charges/{id}',
		'summary'        => 'Retrieves the details of a charge that has been previously created.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The charge unique identifier.',
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
		'uri'            => '/v1/charges',
		'summary'        => 'Creates a new charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'amount' => [
				'description' => 'A positive integer in the smallest currency unit.',
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
				'description' => 'The unique customer identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'card' => [
				'description' => 'A credit card to be charged.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'description' => [
				'description' => 'An arbitrary string which you can attach to a charge object.',
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

			'capture' => [
				'description' => 'Whether or not to immediately capture the charge.',
				'location'    => 'query',
				'type'        => 'boolean',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Boolean::convert',
				],
			],

			'statement_description' => [
				'description' => 'An arbitrary string to be displayed alongside your company name on your customer\'s credit card statement.',
				'location'    => 'query',
				'type'        => 'string',
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

	'update' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{id}',
		'summary'        => 'Updates the specified charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'Charge description.',
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

	'capture' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{id}/capture',
		'summary'        => 'Captures the payment of specified, uncaptured, charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'A positive integer in the smallest currency unit.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'application_fee' => [
				'description' => 'An application fee to add on to this charge. Can only be used with Stripe Connect.',
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

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'refund' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{id}/refunds',
		'summary'        => 'Refunds the specified charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'A positive integer in cents representing how much of this charge to refund.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'refund_application_fee' => [
				'description' => 'Boolean indicating whether the application fee should be refunded when refunding this charge.',
				'location'    => 'query',
				'type'        => 'boolean',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Boolean::convert',
				],
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

	'refunds' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/charges/{id}/refunds',
		'summary'        => 'Retrieves a list of all the refunds of a charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The charge unique identifier.',
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

		],

	],

	'findRefund' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/charges/{charge}/refunds/{id}',
		'summary'        => 'Retrieves the given refund.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'charge' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The refund unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

		],

	],

	'updateRefund' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{charge}/refunds/{id}',
		'summary'        => 'Updates the given refund.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'charge' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The refund unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a charge object.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
