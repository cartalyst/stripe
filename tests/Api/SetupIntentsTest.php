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

class SetupIntentsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_setup_intent()
    {
        $customer = $this->createCustomer();

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method_types' => ['card'],
        ]);

        $this->assertSame($customer['id'], $setupIntent['customer']);
        $this->assertSame(['card'], $setupIntent['payment_method_types']);
    }

    /** @test */
    public function it_can_create_a_new_setup_intent_with_a_card_upfront()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughArray($customer['id']);

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method'       => $card['id'],
            'payment_method_types' => ['card'],
        ]);

        $this->assertSame($customer['id'], $setupIntent['customer']);
        $this->assertSame($card['id'], $setupIntent['payment_method']);
        $this->assertSame(['card'], $setupIntent['payment_method_types']);
    }

    /** @test */
    public function it_can_find_an_existing_setup_intent()
    {
        $customer = $this->createCustomer();

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method_types' => ['card'],
        ]);

        $setupIntent = $this->stripe->setupIntents()->find($setupIntent['id']);

        $this->assertSame($customer['id'], $setupIntent['customer']);
        $this->assertSame(['card'], $setupIntent['payment_method_types']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_setup_intent()
    {
        $this->stripe->setupIntents()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_setup_intent()
    {
        $customer = $this->createCustomer();

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method_types' => ['card'],
        ]);

        $setupIntent = $this->stripe->setupIntents()->update($setupIntent['id'], [
            'description' => 'Some Description',
        ]);

        $this->assertSame($customer['id'], $setupIntent['customer']);
        $this->assertSame(['card'], $setupIntent['payment_method_types']);
        $this->assertSame('Some Description', $setupIntent['description']);
    }

    /** @test */
    public function it_can_confirm_an_existing_setup_intent()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughArray($customer['id']);

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method'       => $card['id'],
            'payment_method_types' => ['card'],
        ]);

        $setupIntent = $this->stripe->setupIntents()->confirm($setupIntent['id']);

        $this->assertSame('succeeded', $setupIntent['status']);
    }

    /** @test */
    public function it_can_cancel_an_existing_setup_intent()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughArray($customer['id']);

        $setupIntent = $this->stripe->setupIntents()->create([
            'customer'             => $customer['id'],
            'payment_method'       => $card['id'],
            'payment_method_types' => ['card'],
        ]);

        $setupIntent = $this->stripe->setupIntents()->cancel($setupIntent['id']);

        $this->assertSame('canceled', $setupIntent['status']);
    }

    /** @test */
    public function it_can_retrieve_all_setup_intents()
    {
        $customer1 = $this->createCustomer();
        $customer2 = $this->createCustomer();

        $this->createSetupIntent();
        $this->createSetupIntent(['customer' => $customer1['id']]);
        $this->createSetupIntent();
        $this->createSetupIntent(['customer' => $customer2['id']]);

        $setupIntents1 = $this->stripe->setupIntents()->all(['customer' => $customer1['id']]);
        $setupIntents2 = $this->stripe->setupIntents()->all(['customer' => $customer1['id']]);

        $this->assertCount(1, $setupIntents1['data']);

        $this->assertCount(1, $setupIntents2['data']);
    }
}
