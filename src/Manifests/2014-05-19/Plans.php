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
		'uri'           => '/v1/plans',
		'summary'       => 'Returns all the existing plans.',
		'responseModel' => 'Response',
		'parameters'    => [

			'limit' => [
				'description' => 'Limit of how many plans are retrieved.',
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
		'uri'           => '/v1/plans/{id}',
		'summary'       => 'Returns an existing plan.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Plan unique identifier.',
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
		'uri'           => '/v1/plans',
		'summary'       => 'Creates a new plan.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Plan unique identifier.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
			],

			'name' => [
				'description' => 'Plan name.',
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

			'interval' => [
				'description' => 'Specify the billing frequency',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => true,
				'enum'        => ['day', 'week', 'month', 'year'],
			],

			'interval_count' => [
				'description' => 'Number of interval between each subscription billing',
				'location'    => 'query',
				'type'        => 'integer',
				'required'    => false,
			],

			'trial_period_days' => [
				'description' => 'Specifies a trial period in (an integer number of) days',
				'location'    => 'query',
				'type'        => 'integer',
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
		'uri'           => '/v1/plans/{id}',
		'summary'       => 'Deletes an existing plan.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Plan unique identifier.',
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
		'uri'           => '/v1/plans/{id}',
		'summary'       => 'Updates an existing plan.',
		'responseModel' => 'Response',
		'parameters'    => [

			'id' => [
				'description' => 'Plan unique identifier.',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'name' => [
				'description' => 'Plan name.',
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

			'expand' => [
				'description' => 'Allows to expand properties.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
