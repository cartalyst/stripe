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
 * @version    2.4.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;
use Cartalyst\Stripe\Exception\CardErrorException;

class ChargesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_charge()
    {
        $charge = $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 50.49,
            'card'     => 'tok_visa',
        ]);

        $this->assertTrue($charge['paid']);
        $this->assertTrue($charge['captured']);
        $this->assertFalse($charge['refunded']);
        $this->assertSame(5049, $charge['amount']);
    }

    /** @test */
    public function it_can_create_a_new_charge_with_an_idempotency_key()
    {
        $chargePayload = [
            'currency' => 'USD',
            'amount'   => 50.49,
            'card'     => 'tok_visa',
        ];

        $charge1 = $this->stripe->charges()->idempotent('charge123')->create($chargePayload);
        $charge2 = $this->stripe->charges()->idempotent('charge123')->create($chargePayload);

        $this->assertSame($charge1['id'], $charge2['id']);
    }

    /** @test */
    public function a_charge_can_be_declined()
    {
        $this->expectException(CardErrorException::class);

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 50.49,
            'card'     => 'tok_chargeDeclined',
        ]);
    }

    /** @test */
    public function it_can_create_a_new_charge_on_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $this->assertTrue($charge['captured']);
        $this->assertSame(5049, $charge['amount']);
    }

    /** @test */
    public function it_can_create_a_new_charge_with_a_currency_with_zero_decimals()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id'], [
            'currency' => 'JPY',
            'amount'   => 80
        ]);

        $this->assertTrue($charge['captured']);
        $this->assertSame(80, $charge['amount']);
    }

    /** @test */
    public function it_can_find_a_charge_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['captured']);
        $this->assertSame(5049, $charge['amount']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_charge()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->charges()->find(time().rand());
    }

    /** @test */
    public function it_can_update_a_charge_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $charge = $this->stripe->charges()->update($charge['id'], [ 'description' => 'PHP Book Payment' ]);

        $this->assertTrue($charge['captured']);
        $this->assertSame(5049, $charge['amount']);
        $this->assertSame('PHP Book Payment', $charge['description']);
    }

    /** @test */
    public function it_can_capture_a_charge_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id'], [ 'capture' => false ]);

        $this->assertFalse($charge['captured']);
        $this->assertSame(5049, $charge['amount']);

        $charge = $this->stripe->charges()->capture($charge['id']);

        $this->assertTrue($charge['captured']);
        $this->assertSame(5049, $charge['amount']);
    }

    /** @test */
    public function it_can_retrieve_all_charges()
    {
        $customer = $this->createCustomer();

        $this->createCharge($customer['id']);

        $charges = $this->stripe->charges()->all();

        $this->assertNotEmpty($charges['data']);
        $this->assertIsArray($charges['data']);
    }

    /** @test */
    public function it_can_iterate_all_charges()
    {
        $customer = $this->createCustomer();

        for ($i=0; $i < 5; $i++) {
            $this->createCharge($customer['id']);
        }

        $charges = $this->stripe->chargesIterator([ 'customer' => $customer['id'] ]);

        $this->assertCount(5, $charges);
    }
}
