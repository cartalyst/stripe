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

	'find' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/events/{id}',
		'summary'        => 'Get details about an event',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'id' => [
				'description' => 'Unique identifier of the event',
				'location'    => 'uri',
				'type'        => 'string',
				'required'    => true,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

	'all' => [

		'httpMethod'     => 'GET',
		'uri'            => '/v1/events',
		'summary'        => 'Get details about all events (up to 30 days)',
		'errorResponses' => $errors,
		'responseClass'  => 'Response',
		'parameters'     => [

			'limit' => [
				'description' => 'Limit on how many events are retrieved',
				'location'    => 'query',
				'type'        => 'integer',
				'min'         => 1,
				'max'         => 100,
				'required'    => false,
			],

			'starting_after' => [
				'description' => 'A cursor for use in the pagination',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'ending_before' => [
				'description' => 'A cursor for use in the pagination',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or a hash',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'type' => [
				'description' => 'Allow to filter events by type',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'expand' => [
				'description' => 'Allow to expand some properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'include' => [
				'description' => 'Allow to include some additional properties',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

		],

	],

];
