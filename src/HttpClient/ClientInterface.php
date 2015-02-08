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

namespace Cartalyst\Stripe\HttpClient;

use GuzzleHttp\Message\RequestInterface;

interface ClientInterface
{
    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey();

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     * @throws \RuntimeException
     */
    public function setApiKey($apiKey);

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion);

    /**
     * Sends a single request.
     *
     * @param RequestInterface $request Request to send
     * @return \GuzzleHttp\Message\ResponseInterface
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function send(RequestInterface $request);
}
