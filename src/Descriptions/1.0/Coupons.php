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
        'uri'            => '/v1/coupons',
        'summary'        => 'Returns a list of coupons that were previously created.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

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
        'uri'            => '/v1/coupons/{id}',
        'summary'        => 'Returns the details of an existing coupon.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The coupon unique identifier.',
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
        'uri'            => '/v1/coupons',
        'summary'        => 'Creates a new coupon.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'Unique string to identify the coupon (if none specified, it will be auto-generated).',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'duration' => [
                'description' => 'Specifies how long the discount will be in effect (can be "forever", "once" or "repeating").',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => true,
                'enum'        => ['forever', 'once', 'repeating'],
            ],

            'amount_off' => [
                'description' => 'A positive amount representing the amount to subtract from an invoice total (required if "percent_off" is not passed).',
                'location'    => 'query',
                'type'        => 'number',
                'required'    => false,
                'filters'     => [
                    'Cartalyst\Stripe\Filters\Number::convert',
                ],
            ],

            'currency' => [
                'description' => 'Currency of the amount_off parameter (required if "amount_off" is passed).',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'duration_in_months' => [
                'description' => 'If "duration" is repeating, a positive integer that specifies the number of months the discount will be in effect.',
                'location'    => 'query',
                'type'        => 'integer',
                'required'    => false,
            ],

            'max_redemptions' => [
                'description' => 'A positive amount specifying the number of times the coupon can be redeemed before it\'s no longer valid.',
                'location'    => 'query',
                'type'        => 'integer',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a coupon object.',
                'location'    => 'query',
                'type'        => 'array',
                'required'    => false,
            ],

            'percent_off' => [
                'description' => 'A positive amount between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed).',
                'location'    => 'query',
                'type'        => 'integer',
                'required'    => false,
            ],

            'redeem_by' => [
                'description' => 'UTC timestamp specifying the last time at which the coupon can be redeemed.',
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

    'destroy' => [

        'httpMethod'     => 'DELETE',
        'uri'            => '/v1/coupons/{id}',
        'summary'        => 'Deletes an existing coupon.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The coupon unique identifier.',
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
