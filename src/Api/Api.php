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

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use Cartalyst\Stripe\Stripe;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\ClientInterface;
use Cartalyst\Stripe\ConfigInterface;
use Psr\Http\Message\RequestInterface;
use Cartalyst\Stripe\Exception\Handler;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;

abstract class Api implements ApiInterface
{
    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * Number of items to return per page.
     *
     * @var int|null
     */
    protected $perPage;

    /**
     * The idempotency key.
     *
     * @var string
     */
    protected $idempotencyKey;

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
    public function idempotent(string $idempotencyKey): ApiInterface
    {
        $this->idempotencyKey = $idempotencyKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function _get(string $url, array $parameters = []): ApiResponse
    {
        if ($perPage = $this->getPerPage()) {
            $parameters['limit'] = $perPage;
        }

        return $this->sendRequest('get', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _delete(string $url, array $parameters = []): ApiResponse
    {
        return $this->sendRequest('delete', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _post(string $url, array $parameters = []): ApiResponse
    {
        return $this->sendRequest('post', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(string $httpMethod, string $url, array $parameters = []): ApiResponse
    {
        try {
            $response = $this->getClient()->request($httpMethod, 'v1/'.$url, [
                'query' => $this->buildHttpQuery($parameters),
            ]);

            return $this->buildResponse($response);
        } catch (ClientException $e) {
            new Handler($e);
        }
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
        $headers = $response->getHeaders();

        $body = json_decode((string) $response->getBody(), true);

        return new ApiResponse($body, $headers);
    }

    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return new Client([
            'base_uri' => $this->baseUrl(),
            'handler'  => $this->createHandler(),
        ]);
    }

    /**
     * Create the client handler.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler(): HandlerStack
    {
        $stack = HandlerStack::create();

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            $config = $this->config;

            if ($this->idempotencyKey) {
                $request = $request->withHeader('Idempotency-Key', $this->idempotencyKey);
            }

            if ($accountId = $config->getAccountId()) {
                $request = $request->withHeader('Stripe-Account', $accountId);
            }

            $request = $request->withHeader('User-Agent', $this->generateUserAgent());

            $request = $request->withHeader('Stripe-Version', $config->getApiVersion());

            $request = $request->withHeader('Authorization', 'Basic '.base64_encode($config->getApiKey()));

            return $request->withHeader('X-Stripe-Client-User-Agent', $this->generateClientUserAgentHeader());
        }));

        $stack->push(Middleware::retry(function ($retries, RequestInterface $request, ResponseInterface $response = null, TransferException $exception = null) {
            return $retries < 3 && ($exception instanceof ConnectException || ($response && $response->getStatusCode() >= 500));
        }, function ($retries) {
            return (int) pow(2, $retries) * 1000;
        }));

        return $stack;
    }

    /**
     * Generates the main user agent string.
     *
     * @return string
     */
    protected function generateUserAgent(): string
    {
        $appInfo = $this->config->getAppInfo();

        $userAgent = 'Cartalyst-Stripe/'.Stripe::getVersion();

        if ($appInfo || ! empty($appInfo)) {
            $userAgent .= ' '.$appInfo['name'];

            if ($appVersion = $appInfo['version']) {
                $userAgent .= "/{$appVersion}";
            }

            if ($appUrl = $appInfo['url']) {
                $userAgent .= " ({$appUrl})";
            }
        }

        return $userAgent;
    }

    /**
     * Generates the client user agent header value.
     *
     * @return string
     */
    protected function generateClientUserAgentHeader(): string
    {
        $appInfo = $this->config->getAppInfo();

        $userAgent = [
            'bindings_version' => Stripe::getVersion(),
            'lang'             => 'php',
            'lang_version'     => phpversion(),
            'publisher'        => 'cartalyst',
            'uname'            => php_uname(),
        ];

        if ($appInfo || ! empty($appInfo)) {
            $userAgent['application'] = $appInfo;
        }

        return json_encode($userAgent);
    }

    /**
     * Builds the Http Query.
     *
     * @param array $parameters
     *
     * @return string
     */
    protected function buildHttpQuery(array $parameters): string
    {
        $parameters = array_map(function ($parameter) {
            if (is_bool($parameter)) {
                $parameter = $parameter ? 'true' : 'false';
            }

            if ($parameter === null) {
                $parameter = '';
            }

            return $parameter;
        }, $parameters);

        return http_build_query($parameters);
    }
}
