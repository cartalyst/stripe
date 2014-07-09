<?php namespace Cartalyst\Stripe\Api\Filters;
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
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class Number {

	/**
	 * Converts a number into an integer.
	 *
	 * @param  mixed  $number
	 * @return int
	 */
	public static function convert($number)
	{
		if (is_string($number) || is_float($number))
		{
			return (int) ($number * 100);
		}

		return $number;
	}

}
