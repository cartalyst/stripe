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
