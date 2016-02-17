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
 * @version    2.0.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class SubscriptionsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_subscription_on_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $this->assertSame(1, $subscription['quantity']);
    }

    /** @test */
    public function it_can_find_a_subscription_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->find($customer['id'], $subscription['id']);

        $this->assertSame(1, $subscription['quantity']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_subscription()
    {
        $customer = $this->createCustomer();

        $this->stripe->subscriptions()->find($customer['id'], time().rand());
    }

    /** @test */
    public function it_can_update_a_subscription_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->update(
            $customer['id'], $subscription['id'], [ 'metadata' => [ 'description' => 'Support Subscription' ] ]
        );

        $this->assertSame(1, $subscription['quantity']);
        $this->assertSame('Support Subscription', $subscription['metadata']['description']);
    }

    /** @test */
    public function it_can_cancel_a_subscription_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->cancel($customer['id'], $subscription['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(0, $customer['subscriptions']['total_count']);

        $this->assertNotNull($subscription['ended_at']);
    }

    /** @test */
    public function it_can_cancel_a_subscription_from_an_existing_customer_at_period_end()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->cancel($customer['id'], $subscription['id'], true);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(1, $customer['subscriptions']['total_count']);

        $this->assertNull($subscription['ended_at']);
        $this->assertTrue($subscription['cancel_at_period_end']);
    }

    /** @test */
    public function it_can_reactivate_a_cancelled_subscription()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->cancel($customer['id'], $subscription['id'], true);

        $this->assertNull($subscription['ended_at']);
        $this->assertTrue($subscription['cancel_at_period_end']);

        $subscription = $this->stripe->subscriptions()->reactivate($customer['id'], $subscription['id']);

        $this->assertNull($subscription['ended_at']);
        $this->assertFalse($subscription['cancel_at_period_end']);
    }

    /** @test */
    public function it_can_apply_a_discount_on_a_subscription()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->applyDiscount($customer['id'], $subscription['id'], $coupon['id']);

        $this->assertSame($subscription['discount']['coupon']['id'], $coupon['id']);
    }

    /** @test */
    public function it_can_delete_a_discount_from_a_subscription()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->applyDiscount($customer['id'], $subscription['id'], $coupon['id']);

        $this->assertSame($subscription['discount']['coupon']['id'], $coupon['id']);

        $this->stripe->subscriptions()->deleteDiscount($customer['id'], $subscription['id']);

        $subscription = $this->stripe->subscriptions()->find($customer['id'], $subscription['id']);

        $this->assertNull($subscription['discount']);
    }

    /** @test */
    public function it_can_retrieve_all_subscriptions()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptions = $this->stripe->subscriptions()->all($customer['id']);

        $this->assertNotEmpty($subscriptions['data']);
        $this->assertInternalType('array', $subscriptions['data']);
    }
}
