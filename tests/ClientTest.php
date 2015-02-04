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

namespace Cartalyst\Stripe\Tests;

use Cartalyst\Stripe\Client;
use Cartalyst\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Guzzle client instance.
     *
     * @var \Cartalyst\Stripe\Client
     */
    protected $client;

    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->client = new Client(new Stripe);
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        new Client(new Stripe);
    }

    /** @test */
    public function it_can_get_and_set_the_api_key()
    {
        $this->assertEquals('stripe-api-key', $this->client->getApiKey());

        $this->client->setApiKey('new-stripe-api-key');

        $this->assertEquals('new-stripe-api-key', $this->client->getApiKey());
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->assertEquals('2014-03-28', $this->client->getApiVersion());

        $this->client->setApiVersion('new-stripe-api-version');

        $this->assertEquals('new-stripe-api-version', $this->client->getApiVersion());
    }

    /** @test */
    public function it_can_set_headers()
    {
        $this->client->setHeaders([
            'foo' => 'bar',
        ]);
    }

    /** @test */
    public function it_can_get_the_api_client()
    {
        $this->assertInstanceOf('Cartalyst\Stripe\Stripe', $this->client->getApiClient());
    }
}
