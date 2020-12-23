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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class CouponsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_coupon()
    {
        $coupon = $this->createCoupon();

        $this->assertSame('forever', $coupon['duration']);
    }

    /** @test */
    public function it_can_find_an_existing_coupon()
    {
        $coupon = $this->createCoupon();

        $coupon = $this->stripe->coupons()->find($coupon['id']);

        $this->assertSame('forever', $coupon['duration']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_coupon()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->coupons()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_coupon()
    {
        $coupon = $this->createCoupon();

        $coupon = $this->stripe->coupons()->update($coupon['id'], [
            'metadata' => [ 'description' => '50% Discount Forever' ]
        ]);

        $this->assertSame('forever', $coupon['duration']);
        $this->assertSame('50% Discount Forever', $coupon['metadata']['description']);
    }

    /** @test */
    public function it_can_delete_an_existing_coupon()
    {
        $coupon = $this->createCoupon();

        $coupon = $this->stripe->coupons()->delete($coupon['id']);

        $this->assertTrue($coupon['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_coupons()
    {
        $this->createCoupon();

        $coupons = $this->stripe->coupons()->all();

        $this->assertNotEmpty($coupons['data']);
        $this->assertIsArray($coupons['data']);
    }

    /** @test */
    public function it_can_iterate_all_coupons()
    {
        for ($i=0; $i < 5; $i++) {
            $this->createCoupon();
        }

        $coupons = $this->stripe->couponsIterator();

        $this->assertNotEmpty($coupons);
    }
}
