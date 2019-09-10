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
 * @version    2.2.12
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class RefundsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['refunded']);
        $this->assertSame(5049, $refund['amount']);
    }

    /** @test */
    public function it_can_create_a_partial_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id'], 20.00);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertFalse($charge['refunded']);
        $this->assertSame(2000, $refund['amount']);
    }

    /** @test */
    public function it_can_find_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $refund = $this->stripe->refunds()->find($charge['id'], $refund['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['refunded']);
        $this->assertSame(5049, $refund['amount']);
    }

    /** @test */
    public function it_can_find_a_refund_without_passing_the_charge_id()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $refund = $this->stripe->refunds()->find($refund['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['refunded']);
        $this->assertSame(5049, $refund['amount']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $this->stripe->refunds()->find($charge['id'], time().rand());
    }

    /** @test */
    public function it_can_update_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $refund = $this->stripe->refunds()->update($charge['id'], $refund['id'], [
            'metadata' => [ 'reason' => 'Refunded the payment.' ]
        ]);

        $this->assertSame(5049, $refund['amount']);
        $this->assertSame('Refunded the payment.', $refund['metadata']['reason']);
    }

    /** @test */
    public function it_can_retrieve_all_refunds()
    {
        $customer = $this->createCustomer();

        $charge1 = $this->createCharge($customer['id']);
        $charge2 = $this->createCharge($customer['id']);

        $this->stripe->refunds()->create($charge1['id']);
        $this->stripe->refunds()->create($charge2['id']);

        $refunds = $this->stripe->refunds()->all($charge1['id']);

        $this->assertNotEmpty($refunds['data']);
        $this->assertCount(1, $refunds['data']);
        $this->assertInternalType('array', $refunds['data']);
    }

    /** @test */
    public function it_can_retrieve_all_refunds_without_passing_the_charge_id()
    {
        $customer = $this->createCustomer();

        $charge1 = $this->createCharge($customer['id']);
        $charge2 = $this->createCharge($customer['id']);

        $this->stripe->refunds()->create($charge1['id']);
        $this->stripe->refunds()->create($charge2['id']);

        $refunds = $this->stripe->refunds()->all();

        $this->assertNotEmpty($refunds['data']);
        $this->assertInternalType('array', $refunds['data']);
    }
}
