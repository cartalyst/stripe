<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

use Cartalyst\Collections\Collection;

class Config extends Collection implements ConfigInterface
{
    public function __construct($version, $apiKey, $apiVersion)
    {
        parent::__construct([
            'version'     => $version,
            'api_key'     => $apiKey ?: getenv('STRIPE_API_KEY'),
            'api_version' => $apiVersion ?: getenv('STRIPE_API_VERSION') ?: '2015-02-18',
        ]);
    }
}
