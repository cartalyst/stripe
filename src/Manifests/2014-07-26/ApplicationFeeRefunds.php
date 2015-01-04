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
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

	'all' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/application_fees/{fee_id}/refunds',
		'summary'        => 'Returns a list of refunds that belongs to an application fee.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'fee_id' => [
				'description' => 'The application fee unique identifier.',
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

		],

	],

   'find' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/application_fees/{fee_id}/refunds/{id}',
		'summary'        => 'Returns the details about an application fee refund',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'fee_id' => [
				'description' => 'The application fee unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The application fee refund unique identifier.',
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
		'uri'            => '/v1/application_fees/{fee_id}/refunds',
		'summary'        => 'Refunds an application fee that has previously been collected but not yet refunded.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'fee_id' => [
				'description' => 'The application fee unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'A positive amount for the transaction.',
				'location'    => 'query',
				'type'        => 'number',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Number::convert',
				],
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a application fee refund object.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'update' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/application_fees/{fee_id}/refunds/{id}',
		'summary'        => 'Updates an application fee refund.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'fee_id' => [
				'description' => 'The application fee unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'id' => [
				'description' => 'The application fee refund unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a application fee refund object.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
