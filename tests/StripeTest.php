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
 * @version    2.4.5
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use BadMethodCallException;
use Mockery as m;
use Cartalyst\Stripe\Stripe;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class StripeTest extends TestCase
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
    public function setUp(): void
    {
        $this->stripe = new Stripe('stripe-api-key', '2014-06-17');
    }

    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown(): void
    {
        m::close();
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

        $this->assertEquals(getenv('STRIPE_API_KEY'), $stripe->getApiKey());

        $this->assertEquals(getenv('STRIPE_API_VERSION'), $stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_and_set_the_api_key()
    {
        $this->stripe->setApiKey('new-stripe-api-key');

        $this->assertEquals('new-stripe-api-key', $this->stripe->getApiKey());
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->stripe->setApiVersion('2014-03-28');

        $this->assertEquals('2014-03-28', $this->stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_the_current_package_version()
    {
        $version = $this->stripe->getVersion();

        $this->assertSame('2.4.5', $version);
    }

    /** @test */
    public function it_can_get_and_set_the_amount_converter()
    {
        $this->assertEquals('\\Cartalyst\\Stripe\\AmountConverter::convert', $this->stripe->getAmountConverter());

        $this->stripe->setAmountConverter('\\Cartalyst\\Stripe\\AmountConverter::convert');

        $this->assertEquals('\\Cartalyst\\Stripe\\AmountConverter::convert', $this->stripe->getAmountConverter());
    }

    /** @test */
    public function it_can_create_requests()
    {
        $class = $this->stripe->customers();

        $this->assertInstanceOf('Cartalyst\\Stripe\\Api\\Customers', $class);
    }

    /** @test */
    public function it_throws_an_exception_when_the_request_is_invalid()
    {
        $this->expectException(BadMethodCallException::class);

        $this->stripe->foo();
    }

    /** @test */
    public function can_retrieve_the_stripe_headers_from_thrown_exception()
    {
        try {
            $stripe = new Stripe();

            $stripe->customers()->find('non-existent-customer-'.time());
        } catch (\Exception $e) {
            $headers = $e->getHeaders();

            $this->assertNotNull($headers['stripe-version']);
        }
    }

    /** @test */
    public function it_throws_an_exception_when_the_api_key_is_not_set()
    {
        $this->expectException(RuntimeException::class);

        unset($_SERVER['STRIPE_API_KEY']);
        putenv('STRIPE_API_KEY');

        $stripe = new Stripe();

        $stripe->account()->details();
    }
}
