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
 * @version    2.2.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class WebhookEndpointsTest extends FunctionalTestCase
{
    protected $webhookEndpoint = [];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->webhookEndpoint = $this->stripe->webhookEndpoints()->create([
            'enabled_events' => ['*'],
            'url' => 'https://example.com/my/webhook/endpoint',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->stripe->webhookEndpoints()->delete($this->webhookEndpoint['id']);
    }

    /** @test */
    public function it_can_find_an_existing_webhook_endpoint()
    {
        $webhookEndpoint = $this->webhookEndpoint;

        $webhookEndpoint = $this->stripe->webhookEndpoints()->find($webhookEndpoint['id']);

        $this->assertSame('enabled', $webhookEndpoint['status']);
        $this->assertSame(['*'], $webhookEndpoint['enabled_events']);
        $this->assertSame('https://example.com/my/webhook/endpoint', $webhookEndpoint['url']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_webhook_endpoint()
    {
        $this->stripe->webhookEndpoints()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_webhook_endpoint()
    {
        $webhookEndpoint = $this->webhookEndpoint;

        $webhookEndpoint = $this->stripe->webhookEndpoints()->update($webhookEndpoint['id'], [
            'url' => 'https://example.com/my/webhook-endpoint',
        ]);

        $this->assertSame('enabled', $webhookEndpoint['status']);
        $this->assertSame(['*'], $webhookEndpoint['enabled_events']);
        $this->assertSame('https://example.com/my/webhook-endpoint', $webhookEndpoint['url']);
    }

    /** @test */
    public function it_can_retrieve_all_webhook_endpoints()
    {
        $webhookEndpoints = $this->stripe->webhookEndpoints()->all();

        $this->assertNotEmpty($webhookEndpoints['data']);
        $this->assertInternalType('array', $webhookEndpoints['data']);
    }

    /** @test */
    public function it_can_iterate_all_webhook_endpoints()
    {
        $webhookEndpoints = $this->stripe->webhookEndpoints()->all();

        $this->assertNotEmpty($webhookEndpoints);
    }
}
