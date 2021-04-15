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
 * @version    2.4.5
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class SubscriptionSchedulesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_subscription_schedule()
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

        $this->assertSame($customer['id'], $subscriptionSchedule['customer']);
        $this->assertSame('active', $subscriptionSchedule['status']);
    }

    /** @test */
    public function it_can_find_an_existing_subscription_schedule()
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

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->find($subscriptionSchedule['id']);

        $this->assertSame($customer['id'], $subscriptionSchedule['customer']);
        $this->assertSame('active', $subscriptionSchedule['status']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_subscription_schedule()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->subscriptionSchedules()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_subscription_schedule()
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

        $this->assertSame([], $subscriptionSchedule['metadata']);

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->update($subscriptionSchedule['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame(['foo' => 'bar'], $subscriptionSchedule['metadata']);
    }

    /** @test */
    public function it_can_cancel_an_existing_subscription_schedule()
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

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->cancel($subscriptionSchedule['id']);

        $this->assertSame($customer['id'], $subscriptionSchedule['customer']);
        $this->assertSame('canceled', $subscriptionSchedule['status']);
        $this->assertNotNull($subscriptionSchedule['canceled_at']);
    }

    /** @test */
    public function it_can_release_an_existing_subscription_schedule()
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

        $subscriptionSchedule = $this->stripe->subscriptionSchedules()->release($subscriptionSchedule['id']);

        $this->assertSame($customer['id'], $subscriptionSchedule['customer']);
        $this->assertSame('released', $subscriptionSchedule['status']);
        $this->assertNotNull($subscriptionSchedule['released_at']);
    }

    /** @test */
    public function it_can_retrieve_all_subscription_schedules()
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

        $subscriptionSchedules = $this->stripe->subscriptionSchedules()->all([
            'customer' => $customer['id'],
        ]);

        $this->assertNotEmpty($subscriptionSchedules['data']);
        $this->assertIsArray($subscriptionSchedules['data']);
    }

    /** @test */
    public function it_can_iterate_all_subscription_schedules()
    {
        $customer = $this->createCustomer();

        $plan = $this->createPlan();

        for ($i=0; $i < 5; $i++) {
            $this->stripe->subscriptionSchedules()->create([
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
        }

        $subscriptionSchedules = $this->stripe->subscriptionSchedulesIterator([
            'customer' => $customer['id'],
        ]);

        $this->assertNotEmpty($subscriptionSchedules);
    }
}
