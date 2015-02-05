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

namespace Cartalyst\Stripe\Listeners;

use GuzzleHttp\Event\ErrorEvent;
use Cartalyst\Stripe\Exception\StripeException;

class ErrorListener
{
    /**
     * Constructor.
     *
     * @param  \GuzzleHttp\Event\ErrorEvent  $event
     * @return void
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function __construct(ErrorEvent $event)
    {
        $response = $event->getResponse();

        $statusCode = $response->getStatusCode();

        $body = json_decode($response->getBody(true), true);

        $type = isset($body['error']['type']) ? $body['error']['type'] : null;

        $message = isset($body['error']['message']) ? $body['error']['message'] : null;

        $type = str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $type)));

        $class = "\Cartalyst\Stripe\Exception\{$type}Exception";

        if (class_exists($class)) {
            throw new $class($message, $statusCode);
        } else {
            throw new StripeException($message, $statusCode);
        }
    }
}
