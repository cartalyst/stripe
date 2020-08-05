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

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Cartalyst\Stripe\HttpClient\Util\Multipart;
use Cartalyst\Stripe\HttpClient\Util\QueryString;

class HttpClient implements HttpClientInterface
{
    /**
     * The object that sends HTTP messages.
     *
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $httpClient;

    /**
     * The HTTP request factory.
     *
     * @var \Psr\Http\Message\RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * The HTTP stream factory.
     *
     * @var StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Client\ClientInterface          $httpClient
     * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
     * @param \Psr\Http\Message\StreamFactoryInterface  $streamFactory
     *
     * @return void
     */
    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->httpClient = $httpClient;

        $this->requestFactory = $requestFactory;

        $this->streamFactory = $streamFactory;
    }

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
    public function send(string $method, string $url, array $query = [], array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest($method, $url.QueryString::build($query));

        foreach ($headers as $key => $value) {
            $request = $request->withHeader((string) $key, $value);
        }

        return $this->httpClient->sendRequest($request);
    }

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
    public function sendMultipart(string $method, string $url, array $params, array $files, array $query = [], array $headers = []): ResponseInterface
    {
        $builder = Multipart::createMultipartStreamBuilder($this->streamFactory, $params, $files);

        $request = $this->requestFactory
            ->createRequest($method, $url.QueryString::build($query))
            ->withBody($builder->build())
        ;

        $contentType = sprintf('%s; boundary=%s', Multipart::MULTIPART_CONTENT_TYPE, $builder->getBoundary());

        foreach (array_merge(['Content-Type' => $contentType], $headers) as $key => $value) {
            $request = $request->withHeader((string) $key, $value);
        }

        return $this->httpClient->sendRequest($request);
    }
}
