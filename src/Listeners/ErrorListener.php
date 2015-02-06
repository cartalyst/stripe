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

namespace Cartalyst\Stripe\Listeners;

use GuzzleHttp\Event\ErrorEvent;
use Cartalyst\Stripe\Exception\StripeException;

class ErrorListener
{
    protected $mappedExceptions = [
        // Often missing a required parameter
        400 => 'BadRequestException',

        // Invalid Stripe API key provided
        401 => 'UnauthorizedException',

        // Parameters were valid but request failed
        402 => 'InvalidRequestException',

        // The requested item doesn't exist
        404 => 'NotFoundException',

        // Something went wrong on Stripe's end
        500 => 'ServerErrorException',
        502 => 'ServerErrorException',
        503 => 'ServerErrorException',
        504 => 'ServerErrorException',
    ];

    /**
     * Constructor.
     *
     * @param  \GuzzleHttp\Event\ErrorEvent  $event
     * @return void
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function __construct(ErrorEvent $event)
    {
        $response = $event->getResponse();

        $statusCode = $response->getStatusCode();

        $body = json_decode($response->getBody(true), true);

        $type = isset($body['error']['type']) ? $body['error']['type'] : null;

        $message = isset($body['error']['message']) ? $body['error']['message'] : null;

        $type = str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $type)));

        // Throw an exception by the error type
        $this->handleExceptionByType($type, $message, $statusCode);

        // Throw an exception by the status code
        $this->handleExceptionByStatusCode($message, $statusCode);

        // Not much we can do now, throw a regular exception
        throw new StripeException($message, $statusCode);
    }

    protected function getClassNamespace($class)
    {
        return "\Cartalyst\\Stripe\\Exception\\{$class}";
    }

    /**
     * Throw an exception by the error type.
     *
     * @param  string  $type
     * @param  string $message
     * @param  int  $statusCode
     * @return void
     * @throws mixed
     */
    protected function handleExceptionByType($type, $message, $statusCode)
    {
        $class = $this->getClassNamespace($type.'Exception');

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
            $class = $this->getClassNamespace($this->mappedExceptions[$statusCode]);

            throw new $class($message, $statusCode);
        }
    }
}
