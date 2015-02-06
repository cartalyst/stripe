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

namespace Cartalyst\Stripe;

use GuzzleHttp\Query;
use GuzzleHttp\Event\ErrorEvent;
use GuzzleHttp\Event\BeforeEvent;
use Cartalyst\Stripe\Listeners\ErrorListener;

class HttpClient extends \GuzzleHttp\Client
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Stripe API version.
     *
     * @var string
     */
    protected $apiVersion;

    /**
     * Constructor.
     *
     * @param  string  $apiKey
     * @param  string  $apiVersion
     * @return void
     */
    public function __construct($apiKey = null, $apiVersion = null)
    {
        parent::__construct([
            'base_url' => ['https://api.stripe.com/', ['version' => 'v1']]
        ]);

        $this->setApiKey(
            $apiKey ?: getenv('STRIPE_API_KEY')
        );

        $this->setApiVersion(
            $apiVersion ?: getenv('STRIPE_API_VERSION') ?: $this->apiVersion
        );

        $emitter = $this->getEmitter();

        $emitter->on('before', function(BeforeEvent $event) {
            $event->getRequest()->getQuery()->setAggregator(
                Query::phpAggregator(false)
            );
        });

        // $emitter->on('error', function(ErrorEvent $event, $name) {
        //     new ErrorListener($event, $name);
        // });
    }

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string  $apiKey
     * @return $this
     * @throws \RuntimeException
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
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Sets the Stripe API version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = (string) $apiVersion;

        $this->setDefaultOption('headers/Stripe-Version', $this->apiVersion);
    }

    /**
     * Sets the user agent version.
     *
     * @param  string  $version
     * @return void
     */
    public function setUserAgentVersion($version)
    {
        $this->setDefaultOption('headers/User-Agent', "Cartalyst-Stripe/{$version}");
    }
}
