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

namespace Cartalyst\Stripe\tests;

use Cartalyst\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class StripeTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Stripe API client instance.
     *
     * @var \Cartalyst\Stripe\Stripe
     */
    protected $stripe;

    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->stripe = new Stripe('stripe-api-key', '2014-06-17');
    }

    /** @test */
    public function it_can_create_a_new_instance_using_the_make_method()
    {
        $stripe = Stripe::make('stripe-api-key');

        $this->assertEquals('stripe-api-key', $stripe->getApiKey());
    }

    /** @test */
    public function it_can_create_a_new_instance_using_enviroment_variables()
    {
        $stripe = new Stripe;

        $this->assertEquals('stripe-api-key', $stripe->getApiKey());

        $this->assertEquals('stripe-api-version', $stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_and_set_the_api_key()
    {
        $this->assertEquals('stripe-api-key', $this->stripe->getApiKey());

        $this->stripe->setApiKey('new-stripe-api-key');

        $this->assertEquals('new-stripe-api-key', $this->stripe->getApiKey());
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_throws_an_exception_when_the_api_key_is_not_set()
    {
        // Unset the environment variable
        putenv('STRIPE_API_KEY');

        new Stripe;
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->assertEquals('2014-06-17', $this->stripe->getApiVersion());

        $this->stripe->setApiVersion('2014-01-01');

        $this->assertEquals('2014-01-01', $this->stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_and_set_the_guzzle_client_headers()
    {
        $headers = [
            'some-header' => 'foo-bar',
        ];

        $this->stripe->setHeaders($headers);

        $this->assertEquals($headers, $this->stripe->getHeaders());
    }

    /** @test */
    public function it_can_get_the_current_package_version()
    {
        $this->stripe->getVersion();
    }
}
