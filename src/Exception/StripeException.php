<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Exception;

class StripeException extends \RuntimeException
{
    /**
     * The response headers sent by Stripe.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Constructor.
     *
     * @param string $message
     * @param int    $status
     * @param array  $headers
     *
     * @return void
     */
    public function __construct(string $message, int $status, array $headers = [])
    {
        parent::__construct($message, $status);

        $this->headers = $headers;
    }

    /**
     * Returns the response headers sent by Stripe.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
