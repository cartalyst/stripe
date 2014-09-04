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
		'uri'            => '/v1/charges/{charge}/refunds',
		'summary'        => 'Returns a list of all the refunds of a charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'charge' => [
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

	'find' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/charges/{charge}/refunds/{id}',
		'summary'        => 'Returns the given refund.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
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

	'create' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{charge}/refunds',
		'summary'        => 'Refunds the specified charge.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'charge' => [
				'description' => 'The charge unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'A positive amount representing how much of this charge to refund.',
				'location'    => 'query',
				'type'        => 'number',
				'required'    => false,
				'filters'     => [
					'Cartalyst\Stripe\Api\Filters\Number::convert',
				],
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

	'update' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/charges/{charge}/refunds/{id}',
		'summary'        => 'Updates the given refund.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
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
				'description' => 'A set of key/value pairs that you can attach to a refund object.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
