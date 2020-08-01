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

namespace Cartalyst\Stripe\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * Sends a request with any HTTP method.
     *
     * @param string $method
     * @param string $url
     * @param array  $query
     * @param array  $headers
     *
     * @throws \Http\Client\Exception
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(string $method, string $url, array $query = [], array $headers = []): ResponseInterface;

    /**
     * Sends a multipart request with any HTTP method.
     *
     * @param string $method
     * @param string $url
     * @param array  $params
     * @param array  $files
     * @param array  $query
     * @param array  $headers
     *
     * @throws \Http\Client\Exception
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendMultipart(string $method, string $url, array $params, array $files, array $query = [], array $headers = []): ResponseInterface;
}
