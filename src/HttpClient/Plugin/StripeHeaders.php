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

namespace Cartalyst\Stripe\HttpClient\Plugin;

use Http\Promise\Promise;
use Cartalyst\Stripe\Stripe;
use Http\Client\Common\Plugin;
use Cartalyst\Stripe\ConfigInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
final class StripeHeaders implements Plugin
{
    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * The idempotency key.
     *
     * @var string|null
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
     * Set the idempotency key.
     *
     * @param string|null $idempotencyKey
     *
     * @return void
     */
    public function setIdempotencyKey($idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        foreach ($this->generateHeaders() as $header => $value) {
            if (! $request->hasHeader($header)) {
                $request = $request->withHeader($header, $value);
            }
        }

        return $next($request);
    }

    /**
     * Generates the default request headers.
     *
     * @return array
     */
    protected function generateHeaders(): array
    {
        $headers = [];

        $config = $this->config;

        if ($this->idempotencyKey) {
            $headers['Idempotency-Key'] = $this->idempotencyKey;
        }

        if ($accountId = $config->getAccountId()) {
            $headers['Stripe-Account'] = $accountId;
        }

        $headers['User-Agent'] = $this->generateUserAgent();

        $headers['Stripe-Version'] = $config->getApiVersion();

        $headers['Authorization'] = 'Basic '.base64_encode($config->getApiKey());

        $headers['X-Stripe-Client-User-Agent'] = $this->generateClientUserAgentHeader();

        return $headers;
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
}
