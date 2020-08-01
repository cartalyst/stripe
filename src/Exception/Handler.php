<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
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
        'card_error'        => CardErrorException::class,
        'idempotency_error' => IdempotencyErrorException::class,
    ];

    /**
     * Constructor.
     *
     * @param \GuzzleHttp\Exception\ClientException $exception
     *
     * @throws \Cartalyst\Stripe\Exception\StripeException
     *
     * @return void
     */
    public function __construct(ClientException $exception)
    {
        $response = $exception->getResponse();

        $headers = $response->getHeaders();

        $statusCode = $response->getStatusCode();

        $rawOutput = json_decode((string) $response->getBody(), true);

        $error = $rawOutput['error'] ?? [];

        $errorType = $error['type'] ?? null;

        $message = $error['message'] ?? null;

        if (isset($this->exceptionsByErrorType[$errorType])) {
            $exceptionClass = $this->exceptionsByErrorType[$errorType];

            throw new $exceptionClass($message, $statusCode);
        }

        if ($statusCode === 400) {
            throw new BadRequestException($message, $statusCode, $headers);
        }

        if ($statusCode === 401) {
            throw new UnauthorizedException($message, $statusCode, $headers);
        }

        if ($statusCode === 402) {
            throw new InvalidRequestException($message, $statusCode, $headers);
        }

        if ($statusCode === 404) {
            throw new NotFoundException($message, $statusCode, $headers);
        }

        if ($statusCode === 422) {
            throw new ValidationFailedException($message, $statusCode, $headers);
        }

        if ($statusCode === 429) {
            throw new ApiLimitExceededException($message, $statusCode, $headers);
        }

        if ($statusCode < 500) {
            throw new ClientErrorException($message, $statusCode, $headers);
        }

        throw new ServerErrorException($message, $statusCode, $headers);
    }
}
