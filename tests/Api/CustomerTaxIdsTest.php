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

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class CustomerTaxIds extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_customer_tax_id()
    {
        $customer = $this->createCustomer();

        $taxId = $this->stripe->customerTaxIds()->create($customer['id'], [
            'type'  => 'eu_vat',
            'value' => 'DE123456789',
        ]);

        $this->assertSame('DE', $taxId['country']);
        $this->assertSame('eu_vat', $taxId['type']);
        $this->assertSame('DE123456789', $taxId['value']);
        $this->assertSame($customer['id'], $taxId['customer']);
    }

    /** @test */
    public function it_can_find_an_existing_customer_tax_id()
    {
        $customer = $this->createCustomer();

        $taxId = $this->stripe->customerTaxIds()->create($customer['id'], [
            'type'  => 'eu_vat',
            'value' => 'DE123456789',
        ]);

        $taxId = $this->stripe->customerTaxIds()->find($customer['id'], $taxId['id']);

        $this->assertSame('DE', $taxId['country']);
        $this->assertSame('eu_vat', $taxId['type']);
        $this->assertSame('DE123456789', $taxId['value']);
        $this->assertSame($customer['id'], $taxId['customer']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_customer_tax()
    {
        $customer = $this->createCustomer();

        $this->stripe->customerTaxIds()->find($customer['id'], time());
    }

    /** @test */
    public function it_can_delete_an_existing_customer_tax_id()
    {
        $customer = $this->createCustomer();

        $taxId = $this->stripe->customerTaxIds()->create($customer['id'], [
            'type'  => 'eu_vat',
            'value' => 'DE123456789',
        ]);

        $taxId = $this->stripe->customerTaxIds()->delete($customer['id'], $taxId['id']);

        $this->assertTrue($taxId['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_tax_ids_from_a_customer()
    {
        $customer = $this->createCustomer();

        $this->stripe->customerTaxIds()->create($customer['id'], [
            'type'  => 'eu_vat',
            'value' => 'DE123456789',
        ]);

        $taxIds = $this->stripe->customerTaxIds()->all($customer['id']);

        $this->assertCount(1, $taxIds['data']);
        $this->assertInternalType('array', $taxIds['data']);
    }

    /** @test */
    public function it_can_iterate_all_tax_ids_from_a_customer()
    {
        $customer = $this->createCustomer();

        $this->stripe->customerTaxIds()->create($customer['id'], [
            'type'  => 'eu_vat',
            'value' => 'DE123456789',
        ]);

        $taxIds = $this->stripe->customerTaxIdsIterator($customer['id']);

        $this->assertCount(1, $taxIds);
    }
}
