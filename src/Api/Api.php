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

namespace Cartalyst\Stripe\Api;

use RuntimeException;
use Cartalyst\Stripe\ConfigInterface;
use Psr\Http\Message\ResponseInterface;
use Cartalyst\Stripe\HttpClient\Builder;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Cartalyst\Stripe\HttpClient\HttpClientInterface;
use Cartalyst\Stripe\HttpClient\Plugin\StripeHeaders;
use Cartalyst\Stripe\HttpClient\Message\ResponseMediator;
use Cartalyst\Stripe\HttpClient\Plugin\StripeExceptionThrower;

abstract class Api implements ApiInterface
{
    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * The HTTP headers plugin instance.
     *
     * @var \Cartalyst\Stripe\HttpClient\Plugin\StripeHeaders
     */
    protected $headers;

    /**
     * The HTTP client builder instance.
     *
     * @var \Cartalyst\Stripe\HttpClient\Builder
     */
    protected $builder;

    /**
     * Number of items to return per page.
     *
     * @var int|null
     */
    protected $perPage;

    /**
     * Constructor.
     *
     * @param \Cartalyst\Stripe\ConfigInterface $config
     *
     * @return void
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;

        $this->headers = new StripeHeaders($config);

        $this->builder = $this->makeClientBuilder();
    }

    /**
     * {@inheritdoc}
     */
    public function baseUrl(): string
    {
        return 'https://api.stripe.com';
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    /**
     * {@inheritdoc}
     */
    public function setPerPage(?int $perPage): ApiInterface
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function idempotent(?string $idempotencyKey): ApiInterface
    {
        $this->headers->setIdempotencyKey($idempotencyKey);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function _get(string $uri, array $query = []): ApiResponse
    {
        if ($perPage = $this->getPerPage()) {
            $query['limit'] = $perPage;
        }

        return $this->sendRequest('get', $uri, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function _delete(string $uri, array $query = []): ApiResponse
    {
        return $this->sendRequest('delete', $uri, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function _post(string $uri, array $query = []): ApiResponse
    {
        return $this->sendRequest('post', $uri, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function _postMultipart(string $uri, array $params, array $files, array $headers = []): ApiResponse
    {
        return $this->sendMultipartRequest('post', $uri, $params, $files, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(string $method, string $uri, array $query = []): ApiResponse
    {
        return $this->buildResponse(
            $this->getClient()->send($method, $this->baseUrl().'/v1/'.$uri, $query)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sendMultipartRequest(string $method, string $uri, array $params, array $files, array $headers = []): ApiResponse
    {
        return $this->buildResponse(
            $this->getClient()->sendMultipart($method, $this->baseUrl().'/v1/'.$uri, $params, $files, [], $headers)
        );
    }

    /**
     * Create an HTTP client builder.
     *
     * @return \Cartalyst\Stripe\HttpClient\Builder
     */
    protected function makeClientBuilder(): Builder
    {
        $builder = new Builder();

        $builder->addPlugin($this->headers);
        $builder->addPlugin(new StripeExceptionThrower());
        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new RetryPlugin(['retries' => 2]));

        return $builder;
    }

    /**
     * Builds the request response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    protected function buildResponse(ResponseInterface $response): ApiResponse
    {
        return new ApiResponse(
            ResponseMediator::getContent($response), $response->getHeaders()
        );
    }

    /**
     * Returns an HTTP client instance.
     *
     * @return \Cartalyst\Stripe\HttpClient\HttpClientInterface
     */
    protected function getClient(): HttpClientInterface
    {
        if (! $this->config->getApiKey()) {
            throw new RuntimeException('The Stripe API key is not defined!');
        }

        if (! $this->config->getApiVersion()) {
            throw new RuntimeException('The Stripe API version is not defined!');
        }

        return $this->builder->getHttpClient();
    }
}
