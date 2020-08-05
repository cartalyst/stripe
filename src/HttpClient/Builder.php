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

use Http\Client\Common\Plugin;
use Psr\Http\Client\ClientInterface;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Client\Common\PluginClientFactory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;

final class Builder
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
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * The currently registered plugins.
     *
     * @var \Http\Client\Common\Plugin[]
     */
    protected $plugins = [];

    /**
     * A HTTP client with all our plugins.
     *
     * @var \Cartalyst\Stripe\HttpClient\HttpClientInterface|null
     */
    protected $pluginClient;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Client\ClientInterface|null          $httpClient
     * @param \Psr\Http\Message\RequestFactoryInterface|null $requestFactory
     * @param \Psr\Http\Message\StreamFactoryInterface|null  $streamFactory
     *
     * @return void
     */
    public function __construct(ClientInterface $httpClient = null, RequestFactoryInterface $requestFactory = null, StreamFactoryInterface $streamFactory = null)
    {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();

        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();

        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    /**
     * Get the built HTTP client.
     *
     * @return \Cartalyst\Stripe\HttpClient\HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        if ($this->pluginClient === null) {
            $this->pluginClient = new HttpClient(
                (new PluginClientFactory())->createClient($this->httpClient, $this->plugins),
                $this->requestFactory, $this->streamFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * Add a new plugin to the end of the plugin chain.
     *
     * @param \Http\Client\Common\Plugin $plugin
     *
     * @return void
     */
    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;

        $this->pluginClient = null;
    }

    /**
     * Remove a plugin by its fully qualified class name.
     *
     * @param string $fqcn
     *
     * @return void
     */
    public function removePlugin(string $fqcn): void
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);

                $this->pluginClient = null;
            }
        }
    }
}
