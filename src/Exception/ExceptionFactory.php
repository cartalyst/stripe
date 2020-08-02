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
     * List of mapped exceptions and their corresponding HTTP Statuses.
     *
     * @var array
     */
    protected static $exceptionsByStatusCode = [
        400 => BadRequestException::class,
        401 => UnauthorizedException::class,
        402 => InvalidRequestException::class,
        404 => NotFoundException::class,
        422 => ValidationFailedException::class,
        429 => ApiLimitExceededException::class,
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

            return new $exceptionClass($message, $statusCode, $headers);
        }

        if (isset(static::$exceptionsByStatusCode[$statusCode])) {
            $exceptionClass = static::$exceptionsByStatusCode[$statusCode];

            return new $exceptionClass($message, $statusCode, $headers);
        }

        if ($statusCode < 500) {
            return new ClientErrorException($message, $statusCode, $headers);
        }

        return new ServerErrorException($message, $statusCode, $headers);
    }
}
