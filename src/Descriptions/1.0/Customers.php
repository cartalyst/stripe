<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
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
        'uri'            => '/v1/customers',
        'summary'        => 'Returns all the existing customers.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
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
        'uri'            => '/v1/customers/{id}',
        'summary'        => 'Returns an existing customer.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The customer unique identifier.',
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

        'httpMethod'     => 'POST',
        'uri'            => '/v1/customers',
        'summary'        => 'Creates a new customer.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
        'errorResponses' => $errors,
        'parameters'     => [

            'account_balance' => [
                'description' => 'A positive amount that is the starting account balance for your customer.',
                'location'    => 'query',
                'type'        => 'number',
                'required'    => false,
                'filters'     => [
                    'Cartalyst\Stripe\Filters\Number::convert',
                ],
            ],

            'card' => [
                'description' => 'Unique card identifier (can either be an ID or a hash).',
                'location'    => 'query',
                'type'        => ['string', 'array'],
                'required'    => false,
            ],

            'coupon' => [
                'description' => 'Coupon identifier that applies a discount on all recurring charges.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'description' => [
                'description' => 'Customer description.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'email' => [
                'description' => 'Customer email address.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a customer object.',
                'location'    => 'query',
                'type'        => 'array',
                'required'    => false,
            ],

            'plan' => [
                'description' => 'Plan for the customer.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'quantity' => [
                'description' => 'Quantity you\'d like to apply to the subscription you\'re creating.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'trial_end' => [
                'description' => 'UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.',
                'location'    => 'query',
                'type'        => ['integer', 'string'],
                'required'    => false,
            ],

            'expand' => [
                'description' => 'Allows to expand some properties',
                'location'    => 'query',
                'type'        => 'array',
                'required'    => false,
            ],

        ],

    ],

    'destroy' => [

        'httpMethod'     => 'DELETE',
        'uri'            => '/v1/customers/{id}',
        'summary'        => 'Deletes an existing customer.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The customer unique identifier.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => true,
            ],

            'expand' => [
                'description' => 'Allows to expand some properties',
                'location'    => 'query',
                'type'        => 'array',
                'required'    => false,
            ],

        ],

    ],

    'update' => [

        'httpMethod'     => 'POST',
        'uri'            => '/v1/customers/{id}',
        'summary'        => 'Updates an existing customer.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The customer unique identifier.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => true,
            ],

            'account_balance' => [
                'description' => 'A positive amount that is the starting account balance for your customer.',
                'location'    => 'query',
                'type'        => 'number',
                'required'    => false,
                'filters'     => [
                    'Cartalyst\Stripe\Filters\Number::convert',
                ],
            ],

            'card' => [
                'description' => 'Unique card identifier (can either be an ID or a hash).',
                'location'    => 'query',
                'type'        => ['string', 'array'],
                'required'    => false,
            ],

            'coupon' => [
                'description' => 'Coupon identifier that applies a discount on all recurring charges.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'default_card' => [
                'description' => 'Default card identifier.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'description' => [
                'description' => 'Customer description.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'email' => [
                'description' => 'Customer email address.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a customer object.',
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

    'deleteDiscount' =>    [

        'httpMethod'     => 'DELETE',
        'uri'            => '/v1/customers/{id}/discount',
        'summary'        => 'Deletes an existing customer.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Customer',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The customer unique identifier.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => true,
            ],

        ],

    ],

];
