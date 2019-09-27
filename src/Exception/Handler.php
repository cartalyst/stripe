<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Exception;

use GuzzleHttp\Exception\ClientException;

class Handler
{
    /**
     * List of mapped exceptions and their corresponding error types.
     *
     * @var array
     */
    protected $exceptionsByErrorType = [

        // Card errors are the most common type of error you should expect to handle
        'card_error' => 'CardError',

    ];

    /**
     * List of mapped exceptions and their corresponding status codes.
     *
     * @var array
     */
    protected $exceptionsByStatusCode = [

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
     * Constructor.
     *
     * @param  \GuzzleHttp\Exception\ClientException  $exception
     * @return void
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function __construct(ClientException $exception)
    {
        $response = $exception->getResponse();

        $headers = $response->getHeaders();

        $statusCode = $response->getStatusCode();

        $rawOutput = json_decode($response->getBody(true), true);

        $error = isset($rawOutput['error']) ? $rawOutput['error'] : [];

        $errorCode = isset($error['code']) ? $error['code'] : null;

        $errorType = isset($error['type']) ? $error['type'] : null;

        $message = isset($error['message']) ? $error['message'] : null;

        $missingParameter = isset($error['param']) ? $error['param'] : null;

        $this->handleException(
            $message, $headers, $statusCode, $errorType, $errorCode, $missingParameter, $rawOutput
        );
    }

    /**
     * Guesses the FQN of the exception to be thrown.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  string  $errorType
     * @param  string  $errorCode
     * @param  string  $missingParameter
     * @return void
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    protected function handleException($message, $headers, $statusCode, $errorType, $errorCode, $missingParameter, $rawOutput)
    {
        if ($statusCode === 400 && $errorCode === 'rate_limit') {
            $class = 'ApiLimitExceeded';
        } elseif ($statusCode === 400 && $errorType === 'invalid_request_error') {
            $class = 'MissingParameter';
        } elseif (array_key_exists($errorType, $this->exceptionsByErrorType)) {
            $class = $this->exceptionsByErrorType[$errorType];
        } elseif (array_key_exists($statusCode, $this->exceptionsByStatusCode)) {
            $class = $this->exceptionsByStatusCode[$statusCode];
        } else {
            $class = 'Stripe';
        }

        $class = "\\Cartalyst\\Stripe\\Exception\\{$class}Exception";

        $instance = new $class($message, $statusCode);

        $instance->setHeaders($headers);
        $instance->setErrorCode($errorCode);
        $instance->setErrorType($errorType);
        $instance->setMissingParameter($missingParameter);
        $instance->setRawOutput($rawOutput);

        throw $instance;
    }
}
