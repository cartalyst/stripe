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

namespace Cartalyst\Stripe\HttpClient\Plugin;

use Http\Promise\Promise;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Cartalyst\Stripe\Exception\ExceptionFactory;
use Cartalyst\Stripe\HttpClient\Message\ResponseMediator;

/**
 * @internal
 */
final class StripeExceptionThrower implements Plugin
{
    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @param RequestInterface $request
     * @param callable         $next
     * @param callable         $first
     *
     * @return Promise
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response) {
            $statusCode = $response->getStatusCode();

            if ($statusCode >= 400 && $statusCode < 600) {
                $error = ResponseMediator::getError($response);

                throw ExceptionFactory::create($statusCode, $error['message'] ?? $response->getReasonPhrase(), $error['type'] ?? null, $response->getHeaders());
            }

            return $response;
        });
    }
}
