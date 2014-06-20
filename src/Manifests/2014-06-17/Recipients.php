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
		'uri'           => '/v1/recipients',
		'summary'       => 'Returns a list of existing recipients.',
		'responseModel' => 'Response',
		'parameters'    => [

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

			'verified' => [
				'description' => 'Boolean to only return recipients that are verified or unverified.',
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

	'find' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/recipients/{id}',
		'summary'       => 'Retrieves the details of an existing recipient.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'The recipient unique identifier.',
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
		'uri'           => '/v1/recipients',
		'summary'       => 'Creates a new recipient.',
		'responseModel' => 'Response',
		'parameters'    => [

			'name' => [
				'description' => 'Recipient full, legal name.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'type' => [
				'description' => 'Type of the recipient (can be "individual" or "corporation").',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
				'enum'        => ['individual', 'corporation'],
			],

			'tax_id' => [
				'description' => 'Recipient tax ID.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'bank_account' => [
				'description' => 'A bank account to attach to the recipient.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'card' => [
				'description' => 'A card to attach to the recipient.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'email' => [
				'description' => 'Recipient email address.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'description' => [
				'description' => 'An arbitrary string which you can attach to a recipient object.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a recipient object.',
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

	'delete' => [

		'httpMethod'    => 'DELETE',
		'uri'           => '/v1/recipients/{id}',
		'summary'       => 'Deletes an existing recipient.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'The recipient unique identifier.',
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

	'update' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/recipients/{id}',
		'summary'       => 'Updates an existing recipient.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'The recipient unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'name' => [
				'description' => 'Recipient full, legal name',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'tax_id' => [
				'description' => 'Recipient tax ID.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'bank_account' => [
				'description' => 'A bank account to attach to the recipient.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'email' => [
				'description' => 'Recipient email address.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'description' => [
				'description' => 'An arbitrary string which you can attach to a recipient object.',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'metadata' => [
				'description' => 'A set of key/value pairs that you can attach to a recipient object.',
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

];
