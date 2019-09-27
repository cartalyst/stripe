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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
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
        $toConvert = [ 'amount', 'price' ];

        if (self::needsAmountConversion($parameters)) {
            if ($converter = Stripe::getAmountConverter()) {
                foreach ($toConvert as $to) {
                    if (isset($parameters[$to])) {
                        $parameters[$to] = forward_static_call_array(
                            $converter, [ $parameters[$to] ]
                        );
                    }
                }
            }
        }

        $parameters = array_map(function ($parameter) {
            return is_bool($parameter) ? ($parameter === true ? 'true' : 'false') : $parameter;
        }, $parameters);

        return preg_replace('/\%5B\d+\%5D/', '%5B%5D', http_build_query($parameters));;
    }

    protected static function needsAmountConversion(array $parameters)
    {
        $hasCurrency = isset($parameters['currency']);

        $currencies = [
            'BIF', 'DJF', 'JPY', 'KRW', 'PYG',
            'VND', 'XAF', 'XPF', 'CLP', 'GNF',
            'KMF', 'MGA', 'RWF', 'VUV', 'XOF',
        ];

        return ! $hasCurrency || ($hasCurrency && ! in_array($parameters['currency'], $currencies));
    }
}
