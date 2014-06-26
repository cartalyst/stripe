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

	'current' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/balance',
		'summary'        => 'Retrieves the current account balance.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,

	],

	'all' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/balance/history',
		'summary'        => 'Returns a list of transactions that have contributed to the Stripe account balance.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'available_on' => [
				'description' => 'A filter on the list based on the object available_on field.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'currency' => [
				'description' => '3-letter ISO code for currency.',
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
				'description' => 'Limits of how many customers are retrieved.',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'source' => [
				'description' => 'Only returns transactions that are related to the specified Stripe object ID (e.g. filtering by a charge ID will return all charge and refund transactions).',
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

			'transfer' => [
				'description' => 'For automatic Stripe transfers only, only returns transactions that were transferred out on the specified transfer ID.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'type' => [
				'description' => 'Only returns transactions of the given type.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
				'enum'        => [
					'charge',
					'refund',
					'transfer',
					'adjustment',
					'application_fee',
					'transfer_failure',
					'application_fee_refund',
				],
			],

		],

	],

	'history' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/balance/history/{id}',
		'summary'        => 'Retrieves the balance transaction with the given ID.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The transaction unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

		],

	],

];
