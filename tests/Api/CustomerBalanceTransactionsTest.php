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
 * @version    2.4.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class CustomerBalanceTransactionsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_customer_balance_transaction()
    {
        $customer = $this->createCustomer();

        $balanceTransaction = $this->stripe->customerBalanceTransactions()->create($customer['id'], [
            'amount'  => '-25.50',
            'currency' => 'USD',
        ]);

        $this->assertSame($customer['id'], $balanceTransaction['customer']);
        $this->assertSame(-2550, $balanceTransaction['amount']);
    }

    /** @test */
    public function it_can_find_an_existing_customer_balance_transaction()
    {
        $customer = $this->createCustomer();

        $balanceTransaction = $this->stripe->customerBalanceTransactions()->create($customer['id'], [
            'amount'  => '-25.50',
            'currency' => 'USD',
        ]);

        $balanceTransaction = $this->stripe->customerBalanceTransactions()->find($customer['id'], $balanceTransaction['id']);

        $this->assertSame($customer['id'], $balanceTransaction['customer']);
        $this->assertSame(-2550, $balanceTransaction['amount']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_customer_balance_transaction()
    {
        $this->expectException(NotFoundException::class);

        $customer = $this->createCustomer();

        $this->stripe->customerBalanceTransactions()->find($customer['id'], time());
    }

    /** @test */
    public function it_can_update_an_existing_customer_balance_transaction()
    {
        $customer = $this->createCustomer();

        $balanceTransaction = $this->stripe->customerBalanceTransactions()->create($customer['id'], [
            'amount'  => '-25.50',
            'currency' => 'USD',
        ]);

        $balanceTransaction = $this->stripe->customerBalanceTransactions()->update($customer['id'], $balanceTransaction['id'], [
            'metadata' => [ 'name' => 'John Doe' ],
        ]);

        $this->assertSame($customer['id'], $balanceTransaction['customer']);
        $this->assertSame('John Doe', $balanceTransaction['metadata']['name']);
    }

    /** @test */
    public function it_can_retrieve_all_balance_transactions_of_a_customer()
    {
        $customer = $this->createCustomer();

        $this->stripe->customerBalanceTransactions()->create($customer['id'], [
            'amount'  => '25.50',
            'currency' => 'USD',
        ]);

        $balanceTransactions = $this->stripe->customerBalanceTransactions()->all($customer['id']);

        $this->assertCount(1, $balanceTransactions['data']);
    }

    /** @test */
    public function it_can_iterate_all_balance_transactions_of_a_customer()
    {
        $customer = $this->createCustomer();

        for ($i=0; $i < 5; $i++) {
            $this->stripe->customerBalanceTransactions()->create($customer['id'], [
                'amount'  => '25.50',
                'currency' => 'USD',
            ]);
        }

        $balanceTransactions = $this->stripe->customerBalanceTransactionsIterator($customer['id']);

        $this->assertCount(5, $balanceTransactions);
    }
}
