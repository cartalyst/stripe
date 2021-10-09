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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
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
        $number = preg_replace('/\,/i', '', $number);

        $number = preg_replace('/([^0-9\.\-])/i', '', $number);

        if (! is_numeric($number)) {
            return '0.00';
        }

        $isCents = (bool) preg_match('/^0.\d+$/', $number);

        return ($isCents ? '0' : null).number_format($number * 100., 0, '.', '');
    }
}
