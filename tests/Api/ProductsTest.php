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
 * @version    2.4.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class ProductsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_product()
    {
        $product = $this->createProduct();

        $this->assertSame('T-shirt', $product['name']);
    }

    /** @test */
    public function it_can_find_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->find($product['id']);

        $this->assertSame('T-shirt', $product['name']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_product()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->products()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->update($product['id'], [
            'description' => 'Comfortable gray cotton t-shirt'
        ]);

        $this->assertSame('T-shirt', $product['name']);
        $this->assertSame('Comfortable gray cotton t-shirt', $product['description']);
    }

    /** @test */
    public function it_can_delete_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->update($product['id'], [
            'description' => 'Comfortable gray cotton t-shirt'
        ]);

        $product = $this->stripe->products()->delete($product['id']);

        $this->assertTrue($product['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_products()
    {
        $this->createProduct();

        $products = $this->stripe->products()->all();

        $this->assertNotEmpty($products['data']);
        $this->assertIsArray($products['data']);
    }

    /** @test */
    public function it_can_iterate_all_products()
    {
        $ids = [];

        for ($i=0; $i < 5; $i++) {
            $ids[] = $this->createProduct()['id'];
        }

        $products = $this->stripe->productsIterator(['ids' => $ids]);

        $this->assertCount(5, $products);
    }
}
