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
 * @version    2.2.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class PaymentMethodsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_payment_method()
    {
        $paymentMethod = $this->stripe->paymentMethods()->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
            ],
        ]);

        $this->assertSame('card', $paymentMethod['type']);
        $this->assertSame('visa', $paymentMethod['card']['brand']);
    }

    /** @test */
    public function it_can_find_an_existing_payment_method()
    {
        $paymentMethod = $this->stripe->paymentMethods()->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
            ],
        ]);

        $paymentMethod = $this->stripe->paymentMethods()->find($paymentMethod['id']);

        $this->assertSame('card', $paymentMethod['type']);
        $this->assertSame('visa', $paymentMethod['card']['brand']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_payment_method()
    {
        $this->stripe->paymentMethods()->find(time().rand());
    }

    /** @test */
    public function it_can_attach_and_detach_a_payment_method()
    {
        $customer = $this->createCustomer();

        $paymentMethod = $this->stripe->paymentMethods()->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
            ],
        ]);

        $paymentMethod = $this->stripe->paymentMethods()->attach($paymentMethod['id'], $customer['id']);

        $this->assertSame($customer['id'], $paymentMethod['customer']);

        $paymentMethod = $this->stripe->paymentMethods()->detach($paymentMethod['id']);

        $this->assertNull($paymentMethod['customer']);
    }

    /** @test */
    public function it_can_update_an_existing_payment_method()
    {
        $customer = $this->createCustomer();

        $paymentMethod = $this->stripe->paymentMethods()->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
            ],
        ]);

        $this->assertEmpty($paymentMethod['metadata']);

        $paymentMethod = $this->stripe->paymentMethods()->attach($paymentMethod['id'], $customer['id']);

        $paymentMethod = $this->stripe->paymentMethods()->update($paymentMethod['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame(['foo' => 'bar'], $paymentMethod['metadata']);
    }

    /** @test */
    public function it_can_retrieve_all_payment_methods()
    {
        $customer = $this->createCustomer();

        $paymentMethod = $this->stripe->paymentMethods()->create([
            'type' => 'card',
            'card' => [
                'token' => 'tok_visa',
            ],
        ]);

        $this->stripe->paymentMethods()->attach($paymentMethod['id'], $customer['id']);

        $paymentMethods = $this->stripe->paymentMethods()->all([
            'customer' => $customer['id'],
            'type' => 'card',
        ]);

        $this->assertCount(1, $paymentMethods['data']);
    }

    /** @test */
    public function it_can_iterate_all_payment_methods()
    {
        $customer = $this->createCustomer();

        for ($i=0; $i < 5; $i++) {
            $paymentMethod = $this->stripe->paymentMethods()->create([
                'type' => 'card',
                'card' => [
                    'token' => 'tok_visa',
                ],
            ]);

            $this->stripe->paymentMethods()->attach($paymentMethod['id'], $customer['id']);
        }

        $paymentMethods = $this->stripe->paymentMethodsIterator([
            'customer' => $customer['id'],
            'type' => 'card',
        ]);

        $this->assertCount(5, $paymentMethods);
    }
}
