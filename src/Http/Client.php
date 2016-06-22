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
 * @version    1.0.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Http;

use GuzzleHttp\Query;
use GuzzleHttp\Event\BeforeEvent;
use Cartalyst\Stripe\ConfigInterface;
use Cartalyst\Stripe\Exception\Handler;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\ClientException;

class Client extends \GuzzleHttp\Client implements ClientInterface
{
    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * The query aggregator status.
     *
     * @var bool
     */
    protected $queryAggregator = false;

    /**
     * Constructor.
     *
     * @param  \Cartalyst\Stripe\ConfigInterface  $config
     * @return void
     */
    public function __construct(ConfigInterface $config)
    {
        parent::__construct([ 'base_url' => $config->base_url ]);

        // Set the Config repository instance
        $this->config = $config;

        // Prepare the request headers
        $this->prepareRequestHeaders();

        // Register some before events
        $this->getEmitter()->on('before', function (BeforeEvent $event) {
            // Get the event request
            $request = $event->getRequest();

             // Set the Stripe API key
            $request->setHeader(
                'Authorization', "Basic ".base64_encode($this->config->api_key)
            );

            // Set the query aggregator
            $request->getQuery()->setAggregator(
                Query::phpAggregator($this->queryAggregator)
            );
        });
    }

    /**
     * Sets the query aggregator status.
     *
     * @param  bool  $status
     * @return $this
     */
    public function queryAggregator($status)
    {
        $this->queryAggregator = $status;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function send(RequestInterface $request)
    {
        try {
            return parent::send($request);
        } catch (ClientException $e) {
            new Handler($e);
        }
    }

    /**
     * Prepares the request headers.
     *
     * @return void
     */
    protected function prepareRequestHeaders()
    {
        $config = $this->config;

        $headers = array_filter([
            'Stripe-Version'  => $config->api_version,
            'Idempotency-Key' => $config->idempotency_key,
            'User-Agent'      => "Cartalyst-Stripe/{$config->version}",
        ]);

        foreach ($headers as $key => $value) {
            $this->setDefaultOption("headers/{$key}", $value);
        }
    }
}
