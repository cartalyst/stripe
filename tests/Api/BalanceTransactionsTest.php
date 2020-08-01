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

class BalanceTransactionsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_get_the_retrieve_a_balance_transaction()
    {
        $charge = $this->stripe->charges()->create([
            'currency' => 'USD',
            'amount'   => 5049,
            'card'     => 'tok_visa',
        ]);

        $balanceTransactionId = $charge['balance_transaction'];

        $balanceTransaction = $this->stripe->balanceTransactions()->find($balanceTransactionId);

        $this->assertSame('charge', $balanceTransaction['type']);
        $this->assertSame($charge['id'], $balanceTransaction['source']);
        $this->assertSame($charge['amount'], $balanceTransaction['amount']);
    }

    /** @test */
    public function it_can_retrieve_all_balance_transactions()
    {
        $transactions = $this->stripe->balanceTransactions()->all();

        $this->assertIsArray($transactions['data']);
    }
}
