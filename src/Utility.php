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
 * @version    1.0.4
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
            $parameters['amount'] = forward_static_call_array(
                Stripe::getAmountConverter(), [ $parameters['amount'] ]
            );
        }

        if (isset($parameters['price'])) {
            $parameters['price'] = forward_static_call_array(
                Stripe::getAmountConverter(), [ $parameters['price'] ]
            );
        }

        $parameters = array_map(function ($parameter) {
            return is_bool($parameter) ? ($parameter === true ? 'true' : 'false') : $parameter;
        }, $parameters);

        return $parameters;
    }
}
