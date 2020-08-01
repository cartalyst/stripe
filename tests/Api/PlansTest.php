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

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class PlansTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_plan()
    {
        $plan = $this->createPlan();

        $this->assertSame('Monthly (30$)', $plan['nickname']);
    }

    /** @test */
    public function it_can_find_an_existing_plan()
    {
        $plan = $this->createPlan();

        $plan = $this->stripe->plans()->find($plan['id']);

        $this->assertSame('Monthly (30$)', $plan['nickname']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_plan()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->plans()->find('not_found');
    }

    /** @test */
    public function it_can_update_an_existing_plan()
    {
        $plan = $this->createPlan();

        $plan = $this->stripe->plans()->update($plan['id'], [
            'metadata' => ['description' => 'Monthly Subscription'],
        ]);

        $this->assertSame('Monthly (30$)', $plan['nickname']);
        $this->assertSame('Monthly Subscription', $plan['metadata']['description']);
    }

    /** @test */
    public function it_can_delete_an_existing_plan()
    {
        $plan = $this->createPlan();

        $plan = $this->stripe->plans()->delete($plan['id']);

        $this->assertTrue($plan['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_plans()
    {
        $timestamp = time();

        $this->createPlan();

        $plans = $this->stripe->plans()->all([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($plans['data']);

        $this->assertIsArray($plans['data']);
    }

    /** @test */
    public function it_can_iterate_all_plans()
    {
        $timestamp = time();

        for ($i = 0; $i < 5; $i++) {
            $this->createPlan();
        }

        $plans = $this->stripe->plansIterator([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($plans);
    }
}
