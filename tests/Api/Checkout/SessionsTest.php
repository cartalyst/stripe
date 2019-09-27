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

namespace Cartalyst\Stripe\Tests\Api\Checkout;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class SessionsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_session()
    {
        $session = $this->stripe->checkout()->sessions()->create([
            'cancel_url' => 'http://example.com/cancel',
            'success_url' => 'http://example.com/success',
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'name' => 'T-shirt',
                    'description' => 'Comfortable cotton t-shirt',
                    'amount' => 1500,
                    'currency' => 'usd',
                    'quantity' => 2,
                ],
            ],
        ]);

        $this->assertCount(1, $session['display_items']);
        $this->assertSame('http://example.com/cancel', $session['cancel_url']);
        $this->assertSame('http://example.com/success', $session['success_url']);
    }

    /** @test */
    public function it_can_find_an_existing_session()
    {
        $session = $this->stripe->checkout()->sessions()->create([
            'cancel_url' => 'http://example.com/cancel',
            'success_url' => 'http://example.com/success',
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'name' => 'T-shirt',
                    'description' => 'Comfortable cotton t-shirt',
                    'amount' => 1500,
                    'currency' => 'usd',
                    'quantity' => 2,
                ],
            ],
        ]);

        $session = $this->stripe->checkout()->sessions()->find($session['id']);

        $this->assertCount(1, $session['display_items']);
        $this->assertSame('http://example.com/cancel', $session['cancel_url']);
        $this->assertSame('http://example.com/success', $session['success_url']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_session()
    {
        $this->stripe->checkout()->sessions()->find(time().rand());
    }
}
