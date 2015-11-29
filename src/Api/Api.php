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
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Cartalyst\Stripe\Utility;
use Cartalyst\Stripe\ConfigInterface;
use Psr\Http\Message\RequestInterface;
use Cartalyst\Stripe\Exception\Handler;

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
     * @var null|int
     */
    protected $perPage;

    /**
     * Constructor.
     *
     * @param  \Cartalyst\Stripe\ConfigInterface  $client
     * @return void
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function baseUrl()
    {
        return 'https://api.stripe.com';
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * {@inheritDoc}
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function _get($url = null, $parameters = [])
    {
        if ($this->perPage) {
            $parameters['limit'] = $this->perPage;
        }

        return $this->execute('get', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _head($url = null, array $parameters = [])
    {
        return $this->execute('head', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function _options($url = null, array $parameters = [])
    {
        return $this->execute('options', $url, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function execute($httpMethod, $url, array $parameters = [], array $body = [])
    {
        try {
            $parameters = Utility::prepareParameters($parameters);

            $response = $this->getClient()->{$httpMethod}('v1/'.$url, [ 'query' => $parameters, /*'body' => $body*/ ]);

            return json_decode((string) $response->getBody(), true);
        } catch (\Exception $e) {
            new Handler($e);
        }
    }

    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUrl(), 'handler' => $this->createHandler()
        ]);
    }

    protected function createHandler()
    {
        $handler = HandlerStack::create();

        $handler->push(Middleware::mapRequest(function (RequestInterface $request) {
            $config = $this->config;

            return $request
                ->withHeader('Stripe-Version', $config->getApiVersion())
                ->withHeader('Idempotency-Key', $config->getIdempotencyKey())
                ->withHeader('User-Agent', 'Cartalyst-Stripe/'.$config->getVersion())
                ->withHeader('Authorization', 'Basic '.base64_encode($config->getApiKey()))
            ;
        }));

        return $handler;
    }
}
