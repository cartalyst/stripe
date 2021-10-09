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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class PricesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_recurring_price()
    {
        $product = $this->createProduct();

        $price = $this->createPrice($product['id']);

        $this->assertSame(1500, $price['unit_amount']);
        $this->assertSame('recurring', $price['type']);
    }

    /** @test */
    public function it_can_create_a_new_one_time_price()
    {
        $product = $this->createProduct();

        $price = $this->createPrice($product['id'], false);

        $this->assertSame(1500, $price['unit_amount']);
        $this->assertSame('one_time', $price['type']);
    }

    /** @test */
    public function it_can_find_an_existing_price()
    {
        $product = $this->createProduct();

        $createdPrice = $this->createPrice($product['id']);

        $queriedPrice = $this->stripe->prices()->find($createdPrice['id']);

        $this->assertSame($queriedPrice['id'], $createdPrice['id']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_price()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->prices()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_price()
    {
        $product = $this->createProduct();

        $price = $this->createPrice($product['id']);

        $price = $this->stripe->prices()->update($price['id'], [
            'metadata' => [ 'description' => 'Bi-monthly Subscription' ]
        ]);

        $this->assertSame('Bi-monthly Subscription', $price['metadata']['description']);
    }

    /** @test */
    public function it_can_retrieve_all_prices()
    {
        $timestamp = time();

        $product = $this->createProduct();

        $this->createPrice($product['id']);

        $prices = $this->stripe->prices()->all([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($prices['data']);
        $this->assertIsArray($prices['data']);
    }

    /** @test */
    public function it_can_iterate_all_prices()
    {
        $timestamp = time();

        $product = $this->createProduct();

        for ($i=0; $i < 5; $i++) {
            $this->createPrice($product['id']);
        }

        $prices = $this->stripe->pricesIterator([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertNotEmpty($prices);
    }
}
