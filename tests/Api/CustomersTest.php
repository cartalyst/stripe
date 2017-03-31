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
 * @version    2.0.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class CustomersTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_customer()
    {
        $customer = $this->createCustomer();

        $this->assertSame('john@doe.com', $customer['email']);
    }

    /** @test */
    public function it_can_find_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame('john@doe.com', $customer['email']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_customer()
    {
        $this->stripe->customers()->find(time());
    }

    /** @test */
    public function it_can_update_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->update($customer['id'], [
            'metadata' => [ 'name' => 'John Doe' ],
        ]);

        $this->assertSame('john@doe.com', $customer['email']);
        $this->assertSame('John Doe', $customer['metadata']['name']);
    }

    /** @test */
    public function it_can_update_the_default_card_of_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card1 = $this->createCardThroughToken($customerId)['id'];
        $card2 = $this->createCardThroughToken($customerId)['id'];

        $customer = $this->stripe->customers()->find($customerId);

        $this->assertSame($card1, $customer['default_source']);

        $this->stripe->customers()->update($customerId, [
            'default_source' => $card2,
        ]);

        $customer = $this->stripe->customers()->find($customerId);

        $this->assertSame($card2, $customer['default_source']);
    }

    /** @test */
    public function it_can_delete_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->delete($customer['id']);

        $this->assertTrue($customer['deleted']);
    }

    /** @test */
    public function it_can_apply_a_discount_on_a_customer()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->applyDiscount($customer['id'], $coupon['id']);

        $this->assertSame($customer['discount']['coupon']['id'], $coupon['id']);
    }

    /** @test */
    public function it_can_delete_a_discount_from_a_customer()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->applyDiscount($customer['id'], $coupon['id']);

        $this->assertSame($customer['discount']['coupon']['id'], $coupon['id']);

        $this->stripe->customers()->deleteDiscount($customer['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertNull($customer['discount']);
    }

    /** @test */
    public function it_can_retrieve_all_customers()
    {
        $this->createCustomer();

        $customers = $this->stripe->customers()->all();

        $this->assertNotEmpty($customers['data']);
        $this->assertInternalType('array', $customers['data']);
    }

    /** @test */
    public function it_can_iterate_all_customers()
    {
        for ($i=0; $i < 5; $i++) {
            $this->createCustomer();
        }

        $this->stripe->customersIterator();
    }
}
