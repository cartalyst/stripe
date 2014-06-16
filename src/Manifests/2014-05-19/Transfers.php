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
		'uri'           => '/v1/transfers',
		'summary'       => 'Returns all the existing transfers.',
		'responseModel' => 'Response',
		'parameters'    => [

			'limit' => [
				'description' => 'Limit of how many transfers are retrieved.',
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

			'date' => [
				'description' => 'A filter based on the "date" field. Can be an exact UTC timestamp, or a hash',
				'location'    => 'query',
				'required'    => false,
			],

			'recipient' => [
				'description' => 'Only return transfers for a specific recipient',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'status' => [
				'description' => 'Optionally filter by status',
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

		'httpMethod'    => 'GET',
		'uri'           => '/v1/transfers/{id}',
		'summary'       => 'Returns an existing transfer.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Transfer unique identifier.',
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
		'uri'           => '/v1/transfers',
		'summary'       => 'Creates a new transfer.',
		'responseModel' => 'Response',
		'parameters'    => [

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

			'recipient' => [
				'description' => 'Recipiend id.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'description' => [
				'description' => 'Description. (optional)',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'statement_description' => [
				'description' => 'An arbitrary string which will be displayed on the recipient\'s bank statement',
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

	'update' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/transfers/{id}',
		'summary'       => 'Updates an existing transfer.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Transfer unique identifier. to update',
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

	'cancel' => [

		'httpMethod'    => 'POST',
		'uri'           => '/v1/transfers/{id}/cancel',
		'summary'       => 'Cancels an existing transfer.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Transfer unique identifier.',
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
