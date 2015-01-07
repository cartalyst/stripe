<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

use Guzzle\Http\QueryString;
use Guzzle\Http\QueryAggregator\QueryAggregatorInterface;

class QueryAggregator implements QueryAggregatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function aggregate($key, $value, QueryString $query)
    {
        $response = [];

        foreach ($value as $k => $v) {
            if (is_int($k)) {
                return [
                    $query->encodeValue("{$key}[]") => $value
                ];
            }

            $k = "{$key}[{$k}]";

            if (is_array($v)) {
                $response = array_merge($response, self::aggregate($k, $v, $query));
            } else {
                $response[$query->encodeValue($k)] = $query->encodeValue($v);
            }
        }

        return $response;
    }
}
