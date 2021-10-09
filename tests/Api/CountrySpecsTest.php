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

class CountrySpecsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_get_a_country_spec()
    {
        $countrySpec = $this->stripe->countrySpecs()->find('US');

        $this->assertArrayHasKey('usd', $countrySpec['supported_bank_account_currencies']);
    }

    /** @test */
    public function it_can_get_all_country_specs()
    {
        $countrySpecs = $this->stripe->countrySpecs()->all();

        $this->assertGreaterThan(1, count($countrySpecs['data']));
    }
}
