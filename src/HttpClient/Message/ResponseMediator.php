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

namespace Cartalyst\Stripe\HttpClient\Message;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Cartalyst\Stripe\HttpClient\Util\Json;

/**
 * @internal
 */
final class ResponseMediator
{
    /**
     * Parse and return the JSON response body as a PHP array.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \JsonException
     *
     * @return array
     */
    public static function getContent(ResponseInterface $response): array
    {
        return Json::decode((string) $response->getBody());
    }

    /**
     * Parse and return the error data from the JSON response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array
     */
    public static function getError(ResponseInterface $response): array
    {
        try {
            return self::getContent($response)['error'] ?? [];
        } catch (JsonException $e) {
            return [];
        }
    }
}
