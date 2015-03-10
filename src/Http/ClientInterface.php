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
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Http;

use GuzzleHttp\Message\RequestInterface;

interface ClientInterface
{
    /**
     * Sends a single request.
     *
     * @param  \GuzzleHttp\Message\RequestInterface  $request
     * @return \GuzzleHttp\Message\ResponseInterface|null
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function send(RequestInterface $request);
}
