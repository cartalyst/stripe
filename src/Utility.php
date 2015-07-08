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
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

class Utility
{
    /**
     * Prepares the given parameters.
     *
     * @param  array  $parameters
     * @return array
     */
    public static function prepareParameters(array $parameters)
    {
        if (isset($parameters['amount'])) {
            $parameters['amount'] = static::convertToNumber($parameters['amount']);
        }

        $parameters = array_map(function ($parameter) {
            return is_bool($parameter) ? ($parameter === true ? 'true' : 'false') : $parameter;
        }, $parameters);

        return $parameters;
    }

    /**
     * Converts a number into an integer.
     *
     * @param  mixed  $number
     * @return int
     */
    protected static function convertToNumber($number)
    {
        $number = number_format((float) $number, 2, '.', '');

        if (is_string($number) || is_float($number)) {
            return (int) ($number * 100);
        }

        return $number;
    }
}
