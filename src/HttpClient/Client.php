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

use GuzzleHttp\Query;
use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Message\RequestInterface;
use Cartalyst\Stripe\Exception\StripeException;

class Client extends \GuzzleHttp\Client implements ClientInterface
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Stripe idempotency key.
     *
     * @var string
     */
    protected $idempotencyKey;

    /**
     * The Stripe API version.
     *
     * @var string
     */
    protected $apiVersion = '2015-01-26';

    /**
     * Constructor.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @param  string  $version
     * @return void
     */
    public function __construct($apiKey = null, $apiVersion = null, $version)
    {
        parent::__construct([
            'base_url' => ['https://api.stripe.com/', ['version' => 'v1']]
        ]);

        // Set the Stripe API key
        $this->setApiKey(
            $apiKey ?: getenv('STRIPE_API_KEY')
        );

        // Set the Stripe API version
        $this->setApiVersion(
            $apiVersion ?: getenv('STRIPE_API_VERSION') ?: $this->apiVersion
        );

        // Set the user agent
        $this->setDefaultOption('headers/User-Agent', "Cartalyst-Stripe/{$version}");

        // Set the query aggregator
        $this->getEmitter()->on('before', function(BeforeEvent $event) {
            $aggregator = Query::phpAggregator(false);

            $event->getRequest()->getQuery()->setAggregator($aggregator);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        if ( ! $this->apiKey) {
            throw new \RuntimeException('The Stripe API key is not defined!');
        }

        $this->getEmitter()->on('before', function(BeforeEvent $event) {
            $apiKey = base64_encode($this->apiKey);

            $event->getRequest()->setHeader('Authorization', "Basic {$apiKey}");
        });

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * {@inheritDoc}
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = (string) $apiVersion;

        $this->setDefaultOption('headers/Stripe-Version', $this->apiVersion);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdempotencyKey()
    {
        return $this->idempotencyKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setIdempotencyKey($idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;

        $this->setDefaultOption('headers/Idempotency-Key', $this->idempotencyKey);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function send(RequestInterface $request)
    {
        try {
            return parent::send($request);
         } catch (\Exception $e) {
            return StripeException::make($e);
        }
    }
}
