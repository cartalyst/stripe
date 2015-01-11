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

    'close' => [

        'httpMethod'     => 'POST',
        'uri'            => '/v1/charges/{charge}/dispute/close',
        'summary'        => 'Closes a dispute.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'charge' => [
                'description' => 'The charge unique identifier.',
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

        'httpMethod'     => 'DELETE',
        'uri'            => '/v1/charges/{charge}/dispute',
        'summary'        => 'Updates a dispute.',
        'responseClass'  => 'Cartalyst\Stripe\Models\Response',
        'errorResponses' => $errors,
        'parameters'     => [

            'charge' => [
                'description' => 'The charge unique identifier.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => true,
            ],

            'evidence' => [
                'description' => 'Evidence text.',
                'location'    => 'uri',
                'type'        => 'string',
                'required'    => false,
            ],

            'metadata' => [
                'description' => 'A set of key/value pairs that you can attach to a dispute object.',
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
