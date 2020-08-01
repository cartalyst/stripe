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

namespace Cartalyst\Stripe\HttpClient\Util;

use JsonException;

/**
 * @internal
 */
final class Json
{
    /**
     * Decode the given JSON string to a PHP array.
     *
     * This method mimics PHP 7.3 JSON_THROW_ON_ERROR behaviour.
     *
     * @param string $content
     *
     * @throws \JsonException
     *
     * @return array
     */
    public static function decode(string $content): array
    {
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException(json_last_error_msg());
        }

        return $data;
    }
}
