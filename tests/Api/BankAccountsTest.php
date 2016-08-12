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
 * @version    2.0.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class BankAccountsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_bank_account_through_an_array()
    {
        $customer = $this->createCustomer();

        $bankAccount = $this->createBankAccountThroughArray($customer['id']);

        $this->assertSame('new', $bankAccount['status']);
        $this->assertSame('110000000', $bankAccount['routing_number']);
    }

    /** @test */
    public function it_can_create_a_new_bank_account_through_a_token()
    {
        $customer = $this->createCustomer();

        $bankAccount = $this->createBankAccountThroughToken($customer['id']);

        $this->assertSame('new', $bankAccount['status']);
        $this->assertSame('110000000', $bankAccount['routing_number']);
    }

    /** @test */
    public function it_can_find_an_existing_bank_account()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $bankAccount = $this->createBankAccountThroughToken($customerId);

        $bankAccount = $this->stripe->bankAccounts()->find($customerId, $bankAccount['id']);

        $this->assertSame('110000000', $bankAccount['routing_number']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_card()
    {
        $customer = $this->createCustomer();

        $this->stripe->bankAccounts()->find($customer['id'], time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_bank_account()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $bankAccount = $this->createBankAccountThroughToken($customerId);

        $bankAccount = $this->stripe->bankAccounts()->update($customerId, $bankAccount['id'], [
            'account_holder_name' => 'John Doe'
        ]);

        $this->assertSame('110000000', $bankAccount['routing_number']);
        $this->assertSame('John Doe', $bankAccount['account_holder_name']);
    }

    /** @test */
    public function it_can_delete_an_existing_bank_account()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $bankAccount = $this->createBankAccountThroughToken($customerId);

        $customer = $this->stripe->customers()->find($customerId);

        $this->assertSame(1, $customer['sources']['total_count']);

        $this->stripe->bankAccounts()->delete($customerId, $bankAccount['id']);

        $customer = $this->stripe->customers()->find($customerId);

        $this->assertSame(0, $customer['sources']['total_count']);
    }

    /** @test */
    public function it_can_verify_an_existing_bank_account()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $bankAccount = $this->createBankAccountThroughToken($customerId);

        $bankAccount = $this->stripe->bankAccounts()->verify(
            $customerId, $bankAccount['id'], [ 32, 45 ]
        );

        $this->assertSame('verified', $bankAccount['status']);
    }

    /** @test */
    public function it_can_retrieve_all_bank_accounts()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $this->createBankAccountThroughToken($customerId);

        $bankAccounts = $this->stripe->bankAccounts()->all($customerId);

        $this->assertNotEmpty($bankAccounts['data']);
        $this->assertInternalType('array', $bankAccounts['data']);
    }

    /** @test */
    public function it_can_iterate_all_bank_accounts()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $this->createBankAccountThroughToken($customerId);

        $bankAccounts = $this->stripe->bankAccountsIterator($customerId);

        $this->assertCount(1, $bankAccounts);
    }
}
