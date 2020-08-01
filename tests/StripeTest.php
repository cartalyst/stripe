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

namespace Cartalyst\Stripe\Tests;

use BadMethodCallException;
use Cartalyst\Stripe\Stripe;
use PHPUnit\Framework\TestCase;
use Cartalyst\Stripe\Exception\StripeException;

class StripeTest extends TestCase
{
    /**
     * The Stripe API client instance.
     *
     * @var \Cartalyst\Stripe\Stripe
     */
    protected $stripe;

    /**
     * Setup resources and dependencies.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->stripe = new Stripe(
            getenv('STRIPE_API_KEY'), getenv('STRIPE_API_VERSION')
        );
    }

    /** @test */
    public function it_can_get_and_set_the_api_key()
    {
        $this->stripe->setApiKey('new-stripe-api-key');

        $this->assertSame('new-stripe-api-key', $this->stripe->getApiKey());
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->stripe->setApiVersion('2014-03-28');

        $this->assertSame('2014-03-28', $this->stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_the_current_package_version()
    {
        $version = $this->stripe->getVersion();

        $this->assertSame('3.0.0', $version);
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
        $this->expectExceptionMessage('Undefined method [foo] called.');

        $this->stripe->foo();
    }

    /** @test */
    public function can_retrieve_the_stripe_headers_from_the_thrown_exception()
    {
        try {
            $this->stripe->customers()->find('non-existent-customer-'.time());
        } catch (StripeException $e) {
            $headers = $e->getHeaders();

            $this->assertNotEmpty($headers['request-id']);

            $this->assertSame(getenv('STRIPE_API_VERSION'), $headers['stripe-version'][0]);
        }
    }
}
