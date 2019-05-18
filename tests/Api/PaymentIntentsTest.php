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
 * @version    2.2.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class PaymentIntentsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_payment_intent()
    {
        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $this->assertSame(300000, $paymentIntent['amount']);
        $this->assertSame('requires_source', $paymentIntent['status']);
    }

    /** @test */
    public function it_can_find_an_existing_payment_intent()
    {
        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $paymentIntent = $this->stripe->paymentIntents()->find($paymentIntent['id']);

        $this->assertSame(300000, $paymentIntent['amount']);
        $this->assertSame('requires_source', $paymentIntent['status']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_payment_intent()
    {
        $this->stripe->paymentIntents()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_payment_intent()
    {
        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $paymentIntent = $this->stripe->paymentIntents()->update($paymentIntent['id'], [
            'amount' => 1500,
        ]);

        $this->assertSame(150000, $paymentIntent['amount']);
        $this->assertSame('requires_source', $paymentIntent['status']);
    }

    /** @test */
    public function it_can_confirm_an_existing_payment_intent()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughToken($customer['id']);

        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
            'confirm' => false,
            'customer' => $customer['id'],
            'source' => $card['id'],
            'capture_method' => 'manual',
        ]);

        $paymentIntent = $this->stripe->paymentIntents()->confirm($paymentIntent['id']);

        $this->assertSame('requires_capture', $paymentIntent['status']);
    }

    /** @test */
    public function it_can_capture_an_existing_payment_intent()
    {
        $customer = $this->createCustomer();

        $this->createCardThroughToken($customer['id']);

        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
            'confirm' => true,
            'customer' => $customer['id'],
            'capture_method' => 'manual',
        ]);

        $paymentIntent = $this->stripe->paymentIntents()->capture($paymentIntent['id']);

        $this->assertSame('succeeded', $paymentIntent['status']);
    }

    /** @test */
    public function it_can_cancel_an_existing_payment_intent()
    {
        $paymentIntent = $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $paymentIntent = $this->stripe->paymentIntents()->cancel($paymentIntent['id']);

        $this->assertSame('canceled', $paymentIntent['status']);
    }

    /** @test */
    public function it_can_retrieve_all_payment_intents()
    {
        $timestamp = time();

        $this->stripe->paymentIntents()->create([
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $paymentIntents = $this->stripe->paymentIntents()->all([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($paymentIntents['data']);
        $this->assertInternalType('array', $paymentIntents['data']);
    }

    /** @test */
    public function it_can_iterate_all_payment_intents()
    {
        $timestamp = time();

        for ($i=0; $i < 5; $i++) {
            $this->stripe->paymentIntents()->create([
                'amount'   => 3000,
                'currency' => 'USD',
            ]);
        }

        $paymentIntents = $this->stripe->paymentIntentsIterator([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($paymentIntents);
    }
}
