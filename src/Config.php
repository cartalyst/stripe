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

use Cartalyst\Collections\Collection;

class Config extends Collection implements ConfigInterface
{
    /**
     * Constructor.
     *
     * @param  string  $version
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     * @throws \RuntimeException
     */
    public function __construct($version, $apiKey, $apiVersion)
    {
        $api_key = $apiKey ?: getenv('STRIPE_API_KEY');

        $api_version = $apiVersion ?: getenv('STRIPE_API_VERSION') ?: '2015-03-24';

        if (! $api_key) {
            throw new \RuntimeException('The Stripe API key is not defined!');
        }

        parent::__construct(compact('version', 'api_key', 'api_version'));
    }
}
