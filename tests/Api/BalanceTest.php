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
 * @version    2.2.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class BalanceTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_get_the_current_balance()
    {
        $current = $this->stripe->balance()->current();

        $this->assertSame('usd', $current['pending'][0]['currency']);
        $this->assertSame('usd', $current['available'][0]['currency']);
        $this->assertInternalType('int', $current['pending'][0]['amount']);
        $this->assertInternalType('int', $current['available'][0]['amount']);
    }

    /** @test */
    public function it_can_retrieve_all_transactions()
    {
        $transactions = $this->stripe->balance()->all();

        $this->assertInternalType('array', $transactions['data']);
    }
}
