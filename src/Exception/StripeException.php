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

namespace Cartalyst\Stripe\Exception;

use GuzzleHttp\Exception\ClientException;

class StripeException extends \Exception
{
    /**
     * List of mapped exceptions and their corresponding status codes.
     *
     * @var array
     */
    protected $mappedExceptions = [

        // Often missing a required parameter
        400 => 'BadRequest',

        // Invalid Stripe API key provided
        401 => 'Unauthorized',

        // Parameters were valid but request failed
        402 => 'InvalidRequest',

        // The requested item doesn't exist
        404 => 'NotFound',

        // Something went wrong on Stripe's end
        500 => 'ServerError',
        502 => 'ServerError',
        503 => 'ServerError',
        504 => 'ServerError',

    ];

    /**
     * Handles the given exception.
     *
     * @param  \GuzzleHttp\Exception\ClientException  $exception
     * @return void
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public static function make(ClientException $exception)
    {
        $response = $exception->getResponse();

        $statusCode = $response->getStatusCode();

        $body = json_decode($response->getBody(true), true);

        $type = isset($body['error']['type']) ? $body['error']['type'] : null;

        $message = isset($body['error']['message']) ? $body['error']['message'] : null;

        $type = str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $type)));

        $instance = new static($message, $statusCode);

        // Throw an exception by the error type
        $instance->handleExceptionByType($type, $message, $statusCode);

        // Throw an exception by the status code
        $instance->handleExceptionByStatusCode($message, $statusCode);

        // Not much we can do now, throw a regular exception
        throw $instance;
    }

    /**
     * Returns the given exception class full namespace.
     *
     * @param  string  $exception
     * @return string
     */
    protected function getExceptionClassNamespace($exception)
    {
        return "\\Cartalyst\\Stripe\\Exception\\{$exception}Exception";
    }

    /**
     * Throw an exception by the error type.
     *
     * @param  string  $type
     * @param  string  $message
     * @param  int  $statusCode
     * @return void
     * @throws mixed
     */
    protected function handleExceptionByType($type, $message, $statusCode)
    {
        $class = $this->getExceptionClassNamespace($type);

        if (class_exists($class)) {
            throw new $class($message, $statusCode);
        }
    }

    /**
     * Throw an exception by the status code.
     *
     * @param  string $message
     * @param  int  $statusCode
     * @return void
     * @throws mixed
     */
    protected function handleExceptionByStatusCode($message, $statusCode)
    {
        if (array_key_exists($statusCode, $this->mappedExceptions)) {
            $class = $this->getExceptionClassNamespace($this->mappedExceptions[$statusCode]);

            throw new $class($message, $statusCode);
        }
    }
}
