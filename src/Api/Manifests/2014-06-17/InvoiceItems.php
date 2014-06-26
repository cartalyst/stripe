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
		'uri'           => '/v1/invoiceitems',
		'summary'       => 'Returns all the existing invoice items.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

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

			'date' => [
				'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
				'location'    => 'query',
				'required'    => false,
			],

			'customer' => [
				'description' => 'Only return invoices for a specific customer',
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
		'uri'           => '/v1/invoiceitems/{id}',
		'summary'       => 'Returns an existing invoice item.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice item unique identifier.',
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
		'uri'           => '/v1/invoiceitems',
		'summary'       => 'Creates a new invoice item.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'customer' => [
				'description' => 'ID of the customer who will be billed when this invoice item is billed',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'amount' => [
				'description' => 'Amount (in cents)',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => true,
			],

			'currency' => [
				'description' => '3-letter ISO code for currency',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'invoice' => [
				'description' => 'Identifier of an existing invoice to add this invoice item to',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'subscription' => [
				'description' => 'Identifier of a subscription to add this invoice item to',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'description' => [
				'description' => 'Description. (optional)',
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

	'delete' => [

		'httpMethod'    => 'DELETE',
		'uri'           => '/v1/invoiceitems/{id}',
		'summary'       => 'Deletes an existing invoice item.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice item unique identifier.',
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
		'uri'           => '/v1/invoiceitems/{id}',
		'summary'       => 'Updates an existing invoice item.',
		'responseClass' => 'Cartalyst\Stripe\Api\Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice item unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'Description. (optional)',
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

];
