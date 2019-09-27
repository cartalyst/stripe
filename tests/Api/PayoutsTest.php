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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class PayoutsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_payout()
    {
        $accountId = $this->createTestManagedAccount()['id'];

        $this->stripe->accountId($accountId);

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
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $this->assertSame('pending', $payout['status']);

        $payout = $this->stripe->payouts()->find($payout['id']);

        $this->assertSame('paid', $payout['status']);
    }

    /** @test */
    public function it_can_find_an_existing_payout()
    {
        $accountId = $this->createTestManagedAccount()['id'];

        $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 15049,
            'source' => [
                'object' => 'card',
                'number' => '4000000000000077',
                'exp_month' => '09',
                'exp_year' => date('Y') + 3,
            ],
            'destination' => [
                'account' => $accountId,
            ],
        ]);

        $payout = $this->stripe->accountId($accountId)->payouts()->create([
            'amount' => 1000,
            'currency' => 'USD',
        ]);

        $payout = $this->stripe->accountId($accountId)->payouts()->find($payout['id']);

        $this->assertSame('paid', $payout['status']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_payout()
    {
        $this->stripe->payouts()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_payout()
    {
        $accountId = $this->createTestManagedAccount()['id'];

        $this->stripe->accountId($accountId);

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
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $payout = $this->stripe->payouts()->update($payout['id'], [
            'metadata' => [ 'description' => 'Awesome description' ]
        ]);

        $this->assertSame('Awesome description', $payout['metadata']['description']);
    }

    /** @test */
    public function it_can_retrieve_all_payouts()
    {
        $accountId = $this->createTestManagedAccount()['id'];

        $this->stripe->accountId($accountId);

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
            'amount' => 3000,
            'currency' => 'USD',
        ]);

        $payouts = $this->stripe->payouts()->all();

        $this->assertCount(1, $payouts['data']);
        $this->assertNotEmpty($payouts['data']);
        $this->assertInternalType('array', $payouts['data']);
    }

    /** @test */
    public function it_can_iterate_all_payouts()
    {
        $accountId = $this->createTestManagedAccount()['id'];

        $this->stripe->accountId($accountId);

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

        for ($i=0; $i < 5; $i++) {
            $payout = $this->stripe->payouts()->create([
                'amount' => 2000,
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
