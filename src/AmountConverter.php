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
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

class AmountConverter
{
    /**
     * Converts the given number into cents.
     *
     * @param  mixed  $number
     * @return string
     */
    public static function convert($number)
    {
        $match = preg_match('/^(.+)[^\d](\d{1,})*$/', $number);

        if (is_double($number) && ! $match) {
            $number = number_format($number, 2, '', '');
        }

        if ($match && $number * 100 != 0) {
            $number = $number * 100;
        }

        return (string) $number;
    }
}
