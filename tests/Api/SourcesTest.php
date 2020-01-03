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
 * @version    2.3.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class SourcesTest extends FunctionalTestCase
{
    /** @test */
    public function a_source_can_be_created()
    {
        $source = $this->stripe->sources()->create([
            'type' => 'ach_credit_transfer',
            'currency' => 'usd',
            'owner' => [
                'email' => 'john@doe.com',
            ],
        ]);

        $this->assertSame('pending', $source['status']);
        $this->assertArrayNotHasKey('customer', $source);
        $this->assertSame('john@doe.com', $source['owner']['email']);

        return $source['id'];
    }

    /**
     * @test
     * @depends a_source_can_be_created
     */
    public function a_source_can_be_found($sourceId)
    {
        $source = $this->stripe->sources()->find($sourceId);

        $this->assertSame('pending', $source['status']);
        $this->assertArrayNotHasKey('customer', $source);
        $this->assertSame('john@doe.com', $source['owner']['email']);
    }

    /**
     * @test
     * @depends a_source_can_be_created
     */
    public function a_source_can_be_updated($sourceId)
    {
        $source = $this->stripe->sources()->update($sourceId, [
            'metadata' => [
                'orderId' => 123456789,
            ],
        ]);

        $this->assertArrayNotHasKey('customer', $source);
        $this->assertSame('123456789', $source['metadata']['orderId']);
    }

    /**
     * @test
     * @depends a_source_can_be_created
     */
    public function a_source_can_be_attached_to_a_customer($sourceId)
    {
        $customer = $this->createCustomer();

        $source = $this->stripe->sources()->attach($customer['id'], $sourceId);

        $this->assertSame($customer['id'], $source['customer']);

        return [$customer['id'], $sourceId];
    }

    /**
     * @test
     * @depends a_source_can_be_attached_to_a_customer
     */
    public function a_source_can_be_detached_from_a_customer($parameters)
    {
        list($customerId, $sourceId) = $parameters;

        $source = $this->stripe->sources()->detach($customerId, $sourceId);

        $this->assertSame('consumed', $source['status']);
    }

    /** @test */
    public function it_can_retrieve_all_sources()
    {
        $customer = $this->createCustomer();

        $this->createCardThroughToken($customer['id']);
        $this->createBankAccountThroughToken($customer['id']);

        $sources = $this->stripe->sources()->all($customer['id']);

        $this->assertNotEmpty($sources['data']);
        $this->assertCount(2, $sources['data']);
        $this->assertInternalType('array', $sources['data']);
    }
}
