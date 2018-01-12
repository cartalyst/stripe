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
 * @version    2.1.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2018, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class SkusTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_sku()
    {
        $product = $this->createProduct();

        $sku = $this->createSku($product['id']);

        $this->assertSame(1500, $sku['price']);
    }

    /** @test */
    public function it_can_find_an_existing_sku()
    {
        $product = $this->createProduct();

        $sku = $this->createSku($product['id']);

        $sku = $this->stripe->skus()->find($sku['id']);

        $this->assertSame(1500, $sku['price']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_sku()
    {
        $this->stripe->skus()->find(time());
    }

    /** @test */
    public function it_can_update_an_existing_sku()
    {
        $product = $this->createProduct();

        $sku = $this->createSku($product['id']);

        $sku = $this->stripe->skus()->update($sku['id'], [
            'metadata' => [ 'description' => 'Comfortable gray cotton t-shirt' ]
        ]);

        $this->assertSame(1500, $sku['price']);
        $this->assertSame('Comfortable gray cotton t-shirt', $sku['metadata']['description']);
    }

    /** @test */
    public function it_can_delete_an_existing_sku()
    {
        $product = $this->createProduct();

        $sku = $this->createSku($product['id']);

        $sku = $this->stripe->skus()->delete($sku['id']);

        $this->assertTrue($sku['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_skus()
    {
        $product = $this->createProduct();

        $this->createSku($product['id']);

        $skus = $this->stripe->skus()->all();

        $this->assertNotEmpty($skus['data']);
        $this->assertInternalType('array', $skus['data']);
    }
}
