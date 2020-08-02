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

class ExceptionFactory
{
    /**
     * List of mapped exceptions and their corresponding error types.
     *
     * @var array
     */
    protected static $exceptionsByErrorType = [
        'card_error'        => CardErrorException::class,
        'idempotency_error' => IdempotencyErrorException::class,
    ];

    /**
     * Handle a failed HTTP response.
     *
     * @param int         $statusCode
     * @param string      $message
     * @param string|null $type
     * @param array       $headers
     *
     * @return \Cartalyst\Stripe\Exception\StripeException
     */
    public static function create(int $statusCode, string $message, string $type = null, array $headers = []): StripeException
    {
        if ($type !== null && isset(static::$exceptionsByErrorType[$type])) {
            $exceptionClass = static::$exceptionsByErrorType[$type];

            return new $exceptionClass($message, $statusCode);
        }

        if ($statusCode === 400) {
            return new BadRequestException($message, $statusCode, $headers);
        }

        if ($statusCode === 401) {
            return new UnauthorizedException($message, $statusCode, $headers);
        }

        if ($statusCode === 402) {
            return new InvalidRequestException($message, $statusCode, $headers);
        }

        if ($statusCode === 404) {
            return new NotFoundException($message, $statusCode, $headers);
        }

        if ($statusCode === 422) {
            return new ValidationFailedException($message, $statusCode, $headers);
        }

        if ($statusCode === 429) {
            return new ApiLimitExceededException($message, $statusCode, $headers);
        }

        if ($statusCode < 500) {
            return new ClientErrorException($message, $statusCode, $headers);
        }

        return new ServerErrorException($message, $statusCode, $headers);
    }
}
