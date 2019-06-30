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

class SubscriptionScheduleRevisionsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_find_an_existing_subscription_schedule_revision()
    {
        $customer = $this->createCustomer();

        $plan = $this->createPlan();

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->create([
            'customer' => $customer['id'],
            'start_date' => time(),
            'phases' => [
                [
                    'plans' => [
                        ['plan' => $plan['id'], 'quantity' => 1],
                    ],
                    'iterations' => 12,
                ],
            ],
            'renewal_behavior' => 'none',
        ]);

        $subscriptionScheduleRevision = $this->stripe->subscriptionScheduleRevisions()->find($subscriptionSchedule['id'], $subscriptionSchedule['revision']);

        $this->assertSame($subscriptionSchedule['id'], $subscriptionScheduleRevision['schedule']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_subscription_schedule_revision()
    {
        $customer = $this->createCustomer();

        $plan = $this->createPlan();

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->create([
            'customer' => $customer['id'],
            'start_date' => time(),
            'phases' => [
                [
                    'plans' => [
                        ['plan' => $plan['id'], 'quantity' => 1],
                    ],
                    'iterations' => 12,
                ],
            ],
            'renewal_behavior' => 'none',
        ]);

        $this->stripe->subscriptionScheduleRevisions()->find($subscriptionSchedule['id'], time().rand());
    }

    /** @test */
    public function it_can_retrieve_all_subscription_schedule_revisions()
    {
        $customer = $this->createCustomer();

        $plan = $this->createPlan();

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->create([
            'customer' => $customer['id'],
            'start_date' => time(),
            'phases' => [
                [
                    'plans' => [
                        ['plan' => $plan['id'], 'quantity' => 1],
                    ],
                    'iterations' => 12,
                ],
            ],
            'renewal_behavior' => 'none',
        ]);

        $subscriptionScheduleRevisions = $this->stripe->subscriptionScheduleRevisions()->all($subscriptionSchedule['id']);

        $this->assertNotEmpty($subscriptionScheduleRevisions['data']);
        $this->assertInternalType('array', $subscriptionScheduleRevisions['data']);
    }

    /** @test */
    public function it_can_iterate_all_subscription_schedule_revisions()
    {
        $customer = $this->createCustomer();

        $plan = $this->createPlan();

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->create([
            'customer' => $customer['id'],
            'start_date' => time(),
            'phases' => [
                [
                    'plans' => [
                        ['plan' => $plan['id'], 'quantity' => 1],
                    ],
                    'iterations' => 12,
                ],
            ],
            'renewal_behavior' => 'none',
        ]);

        $subscriptionScheduleRevisions = $this->stripe->subscriptionScheduleRevisionsIterator($subscriptionSchedule['id']);

        $this->assertNotEmpty($subscriptionScheduleRevisions);
    }
}
