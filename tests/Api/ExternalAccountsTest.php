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

class ExternalAccountsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_bank_account()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $this->assertSame($accountId, $bankAccount['account']);
        $this->assertSame('bank_account', $bankAccount['object']);
    }

    /** @test */
    public function it_can_retrieve_an_existing_bank_account()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $bankAccount = $this->stripe->externalAccounts()->find($accountId, $bankAccount['id']);

        $this->assertSame($accountId, $bankAccount['account']);
        $this->assertSame('bank_account', $bankAccount['object']);
    }

    /** @test */
    public function it_can_update_an_existing_bank_account()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $bankAccount = $this->stripe->externalAccounts()->update($accountId, $bankAccount['id'], [
            'metadata' => [
                'account_manager' => 'John Doe'
            ],
        ]);

        $this->assertSame('John Doe', $bankAccount['metadata']['account_manager']);
    }

    /** @test */
    public function it_can_delete_an_existing_bank_account()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $bankAccount = $this->stripe->externalAccounts()->delete($accountId, $bankAccount['id']);

        $this->assertTrue($bankAccount['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_bank_accounts()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $externalAccounts = $this->stripe->externalAccounts()->all($accountId);

        $this->assertNotEmpty($externalAccounts['data']);
        $this->assertInternalType('array', $externalAccounts['data']);
    }

    /** @test */
    public function it_can_iterate_all_bank_accounts()
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

        $token = $this->createBankAccountToken();

        $bankAccount = $this->stripe->externalAccounts()->create($accountId, [
            'external_account' => $token['id'],
        ]);

        $externalAccounts = $this->stripe->externalAccountsIterator($accountId);

        $this->assertCount(1, $externalAccounts);
    }
}
