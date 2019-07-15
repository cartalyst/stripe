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
 * @version    2.2.10
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class TaxRatesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_tax_rate()
    {
        $name = 'VAT '.time();

        $taxRate = $this->stripe->taxRates()->create([
            'display_name' => $name,
            'description'  => 'VAT Germany',
            'jurisdiction' => 'DE',
            'percentage'   => 19.0,
            'inclusive'    => false,
        ]);

        $this->assertSame($name, $taxRate['display_name']);
        $this->assertSame('DE', $taxRate['jurisdiction']);
        $this->assertSame('VAT Germany', $taxRate['description']);
    }

    /** @test */
    public function it_can_find_an_existing_tax_rate()
    {
        $name = 'VAT '.time();

        $taxRate = $this->stripe->taxRates()->create([
            'display_name' => $name,
            'description'  => 'VAT Germany',
            'jurisdiction' => 'DE',
            'percentage'   => 19.0,
            'inclusive'    => false,
        ]);

        $taxRate = $this->stripe->taxRates()->find($taxRate['id']);

        $this->assertSame($name, $taxRate['display_name']);
        $this->assertSame('DE', $taxRate['jurisdiction']);
        $this->assertSame('VAT Germany', $taxRate['description']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_tax_rate()
    {
        $this->stripe->taxRates()->find(time());
    }

    /** @test */
    public function it_can_update_an_existing_tax_rate()
    {
        $name = 'VAT '.time();

        $nameNew = 'VAT New '.time();

        $taxRate = $this->stripe->taxRates()->create([
            'display_name' => $name,
            'description'  => 'VAT Germany',
            'jurisdiction' => 'DE',
            'percentage'   => 19.0,
            'inclusive'    => false,
        ]);

        $taxRate = $this->stripe->taxRates()->update($taxRate['id'], [
            'display_name' => $nameNew,
        ]);

        $this->assertSame($nameNew, $taxRate['display_name']);
        $this->assertSame('DE', $taxRate['jurisdiction']);
        $this->assertSame('VAT Germany', $taxRate['description']);
    }

    /** @test */
    public function it_can_retrieve_all_tax_rates()
    {
        $name = 'VAT '.time();

        $this->stripe->taxRates()->create([
            'display_name' => $name,
            'description'  => 'VAT Germany',
            'jurisdiction' => 'DE',
            'percentage'   => 19.0,
            'inclusive'    => false,
        ]);

        $taxRates = $this->stripe->taxRates()->all();

        $this->assertNotEmpty($taxRates['data']);
        $this->assertInternalType('array', $taxRates['data']);
    }

    /** @test */
    public function it_can_iterate_all_tax_rates()
    {
        $name = 'VAT '.time();

        $this->stripe->taxRates()->create([
            'display_name' => $name,
            'description'  => 'VAT Germany',
            'jurisdiction' => 'DE',
            'percentage'   => 19.0,
            'inclusive'    => false,
        ]);

        $taxRates = $this->stripe->taxRatesIterator();

        $this->assertNotEmpty($taxRates);
    }
}
