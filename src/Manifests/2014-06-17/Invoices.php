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
		'uri'           => '/v1/invoices',
		'summary'       => 'Returns all the existing invoices.',
		'responseModel' => 'Response',
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
				'type'        => ['string', 'array'],
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
		'uri'           => '/v1/invoices/{id}',
		'summary'       => 'Returns an existing invoice.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice unique identifier.',
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
		'uri'           => '/v1/invoices',
		'summary'       => 'Creates a new invoice.',
		'responseModel' => 'Response',
		'parameters'    => [

			'customer' => [
				'description' => 'Unique string to identify the plan',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'subscription' => [
				'description' => 'Identifier of the subscription to invoice',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'application_fee' => [
				'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
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
		'uri'           => '/v1/invoices/{id}',
		'summary'       => 'Updates an existing invoice.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'application_fee' => [
				'description' => 'A fee in cents that will be applied to the invoice and transferred to the application owner\'s Stripe account',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'closed' => [
				'description' => 'Boolean representing whether an invoice is closed or not',
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

	'pay' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/invoices/{id}/pay',
		'summary'       => 'Pays an existing invoice.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice unique identifier.',
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

	'invoiceLineItems' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/invoices/{id}/lines',
		'summary'       => 'Returns an existing invoice line items.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Invoice unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'count' => [
				'description' => 'Limit on how many invoice line items are retrieved',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'offset' => [
				'description' => 'Offset into the list of returned items',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'customer' => [
				'description' => 'Only return invoice line items for a specific customer',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'subscription' => [
				'description' => 'In the case of upcoming invoices, the subscription is optional. Otherwise it is ignored',
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

	'upcomingInvoice' => [

		'httpMethod'    => 'GET',
		'uri'           => '/v1/invoices/upcoming',
		'summary'       => 'Get upcoming invoices',
		'responseModel' => 'Response',
		'parameters'    => [

			'customer' => [
				'description' => 'Only return upcoming invoices for a specific customer',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'subscription' => [
				'description' => 'The identifier of the subscription for which you\'d like to retrieve the upcoming invoice',
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

];
