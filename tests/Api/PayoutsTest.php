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
use Cartalyst\Stripe\Exception\BadRequestException;

class PayoutsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_payout()
    {
        $account = $this->createTestManagedAccount();

        $this->stripe->accountId($account['id']);

        try {
            $token = $this->stripe->tokens()->create([
                'card' => [
                    'exp_month' => 10,
                    'cvc'       => 314,
                    'exp_year'  => 2020,
                    'number'    => '4000000000000077',
                ],
            ]);
        } catch (BadRequestException $e) {
            if (substr($e->getMessage(), 0, 43) === 'Your account cannot currently make charges.') {
                $this->markTestSkipped('The test account cannot make charges.');
            } else {
                throw $e;
            }
        }

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 5049,
            'source'   => $token['id'],
        ]);

        $payout = $this->stripe->payouts()->create([
            'amount'   => 3000,
            'currency' => 'USD',
        ]);

        $this->assertSame('pending', $payout['status']);

        $payout = $this->stripe->payouts()->find($payout['id']);

        $this->assertSame('paid', $payout['status']);
    }

    /**
     * @test
     * @depends it_can_create_a_new_payout
     */
    public function it_can_find_an_existing_payout()
    {
        $account = $this->createTestManagedAccount();

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 15049,
            'source'   => [
                'object'    => 'card',
                'number'    => '4000000000000077',
                'exp_month' => '09',
                'exp_year'  => date('Y') + 3,
            ],
            'destination' => [
                'account' => $account['id'],
            ],
        ]);

        $payout = $this->stripe->accountId($account['id'])->payouts()->create([
            'amount'   => 1000,
            'currency' => 'USD',
        ]);

        $payout = $this->stripe->accountId($account['id'])->payouts()->find($payout['id']);

        $this->assertSame('paid', $payout['status']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_payout()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->payouts()->find('not_found');
    }

    /**
     * @test
     * @depends it_can_create_a_new_payout
     */
    public function it_can_update_an_existing_payout()
    {
        $account = $this->createTestManagedAccount();

        $this->stripe->accountId($account['id']);

        $token = $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
                'number'    => '4000000000000077',
            ],
        ])['id'];

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 5049,
            'source'   => $token,
        ]);

        $payout = $this->stripe->payouts()->create([
            'amount'   => 3000,
            'currency' => 'USD',
        ]);

        $payout = $this->stripe->payouts()->update($payout['id'], [
            'metadata' => ['description' => 'Awesome description'],
        ]);

        $this->assertSame('Awesome description', $payout['metadata']['description']);
    }

    /**
     * @test
     * @depends it_can_create_a_new_payout
     */
    public function it_can_retrieve_all_payouts()
    {
        $account = $this->createTestManagedAccount();

        $this->stripe->accountId($account['id']);

        $token = $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
                'number'    => '4000000000000077',
            ],
        ])['id'];

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 5049,
            'source'   => $token,
        ]);

        $this->stripe->payouts()->create([
            'amount'   => 3000,
            'currency' => 'USD',
        ]);

        $payouts = $this->stripe->payouts()->all();

        $this->assertCount(1, $payouts['data']);
        $this->assertNotEmpty($payouts['data']);
        $this->assertIsArray($payouts['data']);
    }

    /**
     * @test
     * @depends it_can_create_a_new_payout
     */
    public function it_can_iterate_all_payouts()
    {
        $account = $this->createTestManagedAccount();

        $this->stripe->accountId($account['id']);

        $token = $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
                'number'    => '4000000000000077',
            ],
        ])['id'];

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 20000,
            'source'   => $token,
        ]);

        $timestamp = time();

        for ($i = 0; $i < 5; $i++) {
            $payout = $this->stripe->payouts()->create([
                'amount'   => 2000,
                'currency' => 'USD',
            ]);
        }

        $payouts = $this->stripe->payoutsIterator([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertCount(5, $payouts);
    }
}
