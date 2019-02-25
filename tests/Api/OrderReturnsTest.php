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
 * @version    2.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2018, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class OrderReturnsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_find_a_return_order()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $this->createCardThroughToken($customerId);

        $product1 = $this->createProduct();
        $sku1 = $this->createSku($product1['id']);

        $product2 = $this->createProduct();
        $sku2 = $this->createSku($product2['id']);

        $items = [
            [ 'type' => 'sku', 'parent' => $sku1['id'] ],
            [ 'type' => 'sku', 'parent' => $sku2['id'] ],
        ];

        $order = $this->createOrder($items);

        $orderId = $order['id'];

        $order = $this->stripe->orders()->pay($orderId, [
            'customer' => $customerId
        ]);

        $this->stripe->refunds()->create($order['charge']);

        $return = $this->stripe->orders()->returnItems($orderId);

        $orderReturn = $this->stripe->orderReturns()->find($return['id']);

        $this->assertCount(4, $orderReturn['items']);
        $this->assertSame($orderReturn['order'], $order['id']);
    }

    /** @test */
    public function it_can_retrieve_all_order_returns()
    {
        $orderReturns = $this->stripe->orderReturns()->all();

        $this->assertNotEmpty($orderReturns['data']);
        $this->assertInternalType('array', $orderReturns['data']);
    }

    /** @test */
    public function it_can_iterate_all_order_returns()
    {
        $timestamp = time();

        $orderReturns = $this->stripe->orderReturnsIterator([
            'created' => [
                'gte' => $timestamp,
            ],
        ]);

        $this->assertCount(0, $orderReturns);
    }
}
