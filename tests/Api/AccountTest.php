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
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class AccountTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_retrieve_the_current_account_details()
    {
        $account = $this->stripe->account()->details();

        $this->assertSame('US', $account['country']);
        $this->assertSame('usd', $account['default_currency']);
    }

    /** @test */
    public function it_can_create_a_new_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_retrieve_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $email = $account['email'];

        $accountId = $account['id'];

        $account = $this->stripe->account()->find($accountId);

        $this->assertSame($accountId, $account['id']);
        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_update_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accountId = $account['id'];

        $email = $this->getRandomEmail();

        $this->stripe->account()->update($accountId, compact('email'));

        $account = $this->stripe->account()->find($accountId);

        $this->assertSame($accountId, $account['id']);
        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_reject_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accountId = $account['id'];

        $this->stripe->account()->reject($accountId, 'other');

        $account = $this->stripe->account()->find($account['id']);

        $this->assertSame('rejected.other', $account['verification']['disabled_reason']);
    }

    /** @test */
    public function it_can_retrieve_all_accounts()
    {
        $email = $this->getRandomEmail();

        $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accounts = $this->stripe->account()->all();

        $this->assertNotEmpty($accounts['data']);
        $this->assertInternalType('array', $accounts['data']);
    }

    /** @test */
    public function it_can_iterate_all_accounts()
    {
        $email = $this->getRandomEmail();

        $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accounts = $this->stripe->accountIterator();

        $this->assertNotEmpty($accounts);
    }

    /** @test */
    public function it_can_use_an_account_to_perform_actions()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accountId = $account['id'];

        $account = $this->stripe->accountId($accountId)->account()->details();

        $this->assertSame($accountId, $account['id']);

        $account = $this->stripe->accountId(null)->account()->details();

        $this->assertNotSame($accountId, $account['id']);
    }

    /** @test */
    public function it_can_delete_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type'                   => 'custom',
            'email'                  => $email,
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accountId = $account['id'];

        $response = $this->stripe->account()->delete($accountId);

        $this->assertSame($accountId, $response['id']);
        $this->assertTrue($response['deleted']);
    }
}
