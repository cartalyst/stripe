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
 * @version    2.2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class UsageRecordsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_subscription_item_usage_record()
    {
        $plan = $this->createPlan([
            'usage_type' => 'metered',
        ]);

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $usageRecord = $this->stripe->usageRecords()->create($subscriptionItem['id'], [
            'quantity'  => 10,
            'timestamp' => strtotime('+3days', $subscription['current_period_start']),
            'action'    => 'set'
        ]);

        $this->assertSame($subscriptionItem['id'], $usageRecord['subscription_item']);
    }

    /** @test */
    public function it_can_retrieve_all_usage_records_of_a_subscription_item()
    {
        $plan = $this->createPlan([
            'usage_type' => 'metered',
        ]);

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $this->stripe->usageRecords()->create($subscriptionItem['id'], [
            'quantity'  => 10,
            'timestamp' => strtotime('+3days', $subscription['current_period_start']),
            'action'    => 'set'
        ]);

        $usageRecords = $this->stripe->usageRecords()->all($subscriptionItem['id']);

        $this->assertCount(1, $usageRecords['data']);
    }
}
