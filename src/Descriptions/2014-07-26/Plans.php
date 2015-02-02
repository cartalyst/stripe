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
        'uri'            => '/v1/plans',
        'summary'        => 'Returns all the existing plans.',
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
        'uri'            => '/v1/plans/{id}',
        'summary'        => 'Returns an existing plan.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The plan unique identifier.',
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
        'uri'            => '/v1/plans',
        'summary'        => 'Creates a new plan.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The plan unique identifier.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => true,
            ],

            'amount' => [
                'description' => 'A positive amount for the transaction.',
                'location'    => 'query',
                'type'        => 'number',
                'required'    => true,
                'filters'     => [
                    'Cartalyst\Stripe\Api\Filters\Number::convert',
                ],
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

            'name' => [
                'description' => 'The name of the plan.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => true,
            ],

            'trial_period_days' => [
                'description' => 'Specifies a trial period in (an integer number of) days',
                'location'    => 'query',
                'type'        => 'integer',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a plan object.',
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

    'destroy' => [

        'httpMethod'     => 'DELETE',
        'uri'            => '/v1/plans/{id}',
        'summary'        => 'Deletes an existing plan.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The plan unique identifier.',
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

        'httpMethod'     => 'POST',
        'uri'            => '/v1/plans/{id}',
        'summary'        => 'Updates an existing plan.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'id' => [
                'description' => 'The plan unique identifier.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => true,
            ],

            'name' => [
                'description' => 'The name of the plan.',
                'location'    => 'query',
                'type'        => 'string',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a plan object.',
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
