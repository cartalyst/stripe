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
 * @version    2.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class TokensTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_and_find_a_token()
    {
        $token = $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 6,
                'cvc'       => 314,
                'exp_year'  => 2050,
                'number'    => '4242424242424242',
            ],
        ]);

        $token = $this->stripe->tokens()->find($token['id']);

        $this->assertSame('4242', $token['card']['last4']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    // public function it_will_throw_an_exception_when_searching_for_a_non_existing_token()
    // {
    //     $this->stripe->tokens()->find(time().rand());
    // }
    # This doesn't work as expected at the moment, since Stripe doesn't return the proper status code of 404, it returns 400! Weird!
}
