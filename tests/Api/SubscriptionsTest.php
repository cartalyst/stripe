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

namespace Cartalyst\Stripe\Tests\Api;

use DateTime;
use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

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

        $subscription = $this->stripe->subscriptions()->find($subscription['id']);

        $this->assertSame(1, $subscription['quantity']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_subscription()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->subscriptions()->find('not_found');
    }

    /** @test */
    public function it_can_update_a_subscription_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->update($subscription['id'], [
            'metadata' => ['description' => 'Support Subscription'],
        ]);

        $this->assertSame(1, $subscription['quantity']);
        $this->assertSame('Support Subscription', $subscription['metadata']['description']);
    }

    /** @test */
    public function it_can_cancel_a_subscription_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->cancel($subscription['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(0, $customer['subscriptions']['total_count']);

        $this->assertNotNull($subscription['ended_at']);
    }

    /** @test */
    public function it_can_cancel_a_subscription_from_an_existing_customer_at_period_end()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->cancelAtPeriodEnd($subscription['id']);

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

        $subscription = $this->stripe->subscriptions()->cancelAtPeriodEnd($subscription['id']);

        $this->assertNull($subscription['ended_at']);
        $this->assertTrue($subscription['cancel_at_period_end']);

        $subscription = $this->stripe->subscriptions()->reactivate($subscription['id']);

        $this->assertNull($subscription['ended_at']);
        $this->assertFalse($subscription['cancel_at_period_end']);
    }

    /** @test */
    public function it_can_apply_a_discount_on_a_subscription()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->applyDiscount($subscription['id'], $coupon['id']);

        $this->assertSame($subscription['discount']['coupon']['id'], $coupon['id']);
    }

    /** @test */
    public function it_can_delete_a_discount_from_a_subscription()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscription = $this->stripe->subscriptions()->applyDiscount($subscription['id'], $coupon['id']);

        $this->assertSame($subscription['discount']['coupon']['id'], $coupon['id']);

        $this->stripe->subscriptions()->deleteDiscount($subscription['id']);

        $subscription = $this->stripe->subscriptions()->find($subscription['id']);

        $this->assertNull($subscription['discount']);
    }

    /** @test */
    public function it_can_retrieve_all_subscriptions_that_belongs_to_a_customer()
    {
        $customer = $this->createCustomer();

        $this->createSubscription($customer['id']);
        $this->createSubscription($customer['id']);

        $subscriptions = $this->stripe->subscriptions()->all([
            'customer' => $customer['id'],
            'status'   => 'all',
        ]);

        $this->assertNotEmpty($subscriptions['data']);
        $this->assertCount(2, $subscriptions['data']);
        $this->assertIsArray($subscriptions['data']);
    }

    /** @test */
    public function it_can_retrieve_all_subscriptions()
    {
        $date = new DateTime();

        $customer1 = $this->createCustomer();
        $customer2 = $this->createCustomer();

        $this->createSubscription($customer1['id']);
        $this->createSubscription($customer2['id']);

        $subscriptions = $this->stripe->subscriptions()->all([
            'status'  => 'all',
            'created' => ['gte' => $date->getTimestamp()],
        ]);

        $this->assertNotEmpty($subscriptions['data']);

        // $this->assertSame($customer2['id'], $subscriptions['data'][0]['customer']);
        // $this->assertSame($customer1['id'], $subscriptions['data'][1]['customer']);

        $this->assertIsArray($subscriptions['data']);
    }

    /** @test */
    public function it_can_retrieve_all_subscriptions_using_the_iterator()
    {
        $customer = $this->createCustomer();

        $this->createSubscription($customer['id']);
        $this->createSubscription($customer['id']);

        $subscription = $this->createSubscription($customer['id']);

        $this->stripe->subscriptions()->cancel($subscription['id']);

        $subscriptions = $this->stripe->subscriptionsIterator([
            'customer' => $customer['id'],
        ]);

        $this->assertNotEmpty($subscriptions);
        $this->assertCount(2, $subscriptions);
        $this->assertIsArray($subscriptions);

        $subscriptions = $this->stripe->subscriptionsIterator([
            'customer' => $customer['id'],
            'status'   => 'canceled',
        ]);

        $this->assertNotEmpty($subscriptions);
        $this->assertCount(1, $subscriptions);
        $this->assertIsArray($subscriptions);

        $subscriptions = $this->stripe->subscriptionsIterator([
            'customer' => $customer['id'],
            'status'   => 'all',
        ]);

        $this->assertNotEmpty($subscriptions);
        $this->assertCount(3, $subscriptions);
        $this->assertIsArray($subscriptions);
    }
}
