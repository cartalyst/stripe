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

/**
 * @internal
 */
final class QueryString
{
    /**
     * Encode parameters as a query string according to RFC 3986.
     *
     * @param array $query
     *
     * @return string
     */
    public static function build(array $query): string
    {
        if (count($query) === 0) {
            return '';
        }

        $query = array_map(function ($param) {
            if (is_bool($param)) {
                $param = $param ? 'true' : 'false';
            }

            if ($param === null) {
                $param = '';
            }

            return $param;
        }, $query);

        return sprintf('?%s', http_build_query($query, '', '&', PHP_QUERY_RFC3986));
    }
}
