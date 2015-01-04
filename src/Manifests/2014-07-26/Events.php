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
		'uri'            => '/v1/events',
		'summary'        => 'Returns a list of events, going back up to 30 days.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'created' => [
				'description' => 'A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
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

			'starting_after' => [
				'description' => 'A cursor to be used in pagination.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'type' => [
				'description' => 'Allows to filter events by type.',
				'location'    => 'query',
				'type'        => 'string',
				'required'    => false,
			],

			'object_id' => [
				'description' => 'The object that this event belongs to.',
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

		'httpMethod'     => 'GET',
		'uri'            => '/v1/events/{id}',
		'summary'        => 'Returns the details of an event.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The event unique identifier.',
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
