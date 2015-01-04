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

	'create' => [

		'httpMethod'     => 'POST',
		'uri'            => '/v1/tokens',
		'summary'        => 'Creates a new token.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'bank_account' => [
				'description' => 'A bank account to attach to the recipient.',
				'location'    => 'query',
				'type'        => 'array',
				'required'    => false,
			],

			'card' => [
				'description' => 'The card unique identifier.',
				'location'    => 'query',
				'type'        => ['string', 'array'],
				'required'    => false,
			],

			'customer' => [
				'description' => 'A customer to create a token for.',
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
		'uri'            => '/v1/tokens/{id}',
		'summary'        => 'Returns the details about an existing token.',
		'responseClass'  => 'Cartalyst\Stripe\Api\Models\Response',
		'errorResponses' => $errors,
		'parameters'     => [

			'id' => [
				'description' => 'The token unique identifier.',
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
