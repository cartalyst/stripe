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
		'uri'            => '/v1/transfers',
		'summary'        => 'Returns a list of the existing transfers.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'created' => [
				'description' => 'A filter on the list based on the object created field. The value can be a string with an integer Unix timestamp, or it can be a dictionary.',
				'location'    => 'query',
				'required'    => false,
			],

			'date' => [
				'description' => 'A filter on the list based on the object date field. The value can be a string with an integer Unix timestamp, or it can be a dictionary.',
				'location'    => 'query',
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

			'recipient' => [
				'description' => 'Only return transfers for the recipient specified by this recipient ID.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'starting_after' => [
				'description' => 'A cursor to be used in pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'status' => [
				'description' => 'Only return transfers that have the given status: "pending", "paid", or "failed".',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
				'enum'        => ['pending', 'paid', 'failed'],
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
		'uri'            => '/v1/transfers/{id}',
		'summary'        => 'Retrieves the details of an existing transfer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The transfer unique identifier.',
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
		'uri'            => '/v1/transfers',
		'summary'        => 'Creates a new transfer.',
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

			'recipient' => [
				'description' => 'The ID of an existing, verified recipient.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'An arbitrary string which you can attach to a transfer object.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'statement_description' => [
				'description' => 'An arbitrary string which will be displayed on the recipient\'s bank statement.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a transfer object',
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

	'update' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/transfers/{id}',
		'summary'        => 'Updates an existing transfer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The transfer unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'An arbitrary string which you can attach to a transfer object.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a transfer object',
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

		'httpMethod'     => 'POST',
		'uri'            => '/v1/transfers/{id}/cancel',
		'summary'        => 'Cancels an existing transfer.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The transfer unique identifier.',
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

];
