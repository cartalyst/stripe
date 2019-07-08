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
 * @version    2.2.8
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Terminal;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class LocationsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_location()
    {
        $location = $this->stripe->terminal()->locations()->create([
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
            'display_name' => 'My First Store',
        ]);

        $this->assertSame('My First Store', $location['display_name']);
    }

    /** @test */
    public function it_can_find_an_existing_location()
    {
        $location = $this->stripe->terminal()->locations()->create([
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
            'display_name' => 'My First Store',
        ]);

        $location = $this->stripe->terminal()->locations()->find($location['id']);

        $this->assertSame('My First Store', $location['display_name']);
    }

    // /**
    //  * @test
    //  * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
    //  */
    // public function it_will_throw_an_exception_when_searching_for_a_non_existing_location()
    // {
    //     $this->stripe->terminal()->locations()->find(time().rand());
    // }

    /** @test */
    public function it_can_update_an_existing_location()
    {
        $location = $this->stripe->terminal()->locations()->create([
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
            'display_name' => 'My First Store',
        ]);

        $this->assertSame('My First Store', $location['display_name']);

        $location = $this->stripe->terminal()->locations()->update($location['id'], [
            'display_name' => 'My Store',
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
        ]);

        $this->assertSame('My Store', $location['display_name']);
    }

    /** @test */
    public function it_can_delete_an_existing_location()
    {
        $location = $this->stripe->terminal()->locations()->create([
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
            'display_name' => 'My First Store',
        ]);

        $location = $this->stripe->terminal()->locations()->delete($location['id']);

        $this->assertTrue($location['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_locations()
    {
        $this->stripe->terminal()->locations()->create([
            'address' => [
                'line1'       => '1234 Main Street',
                'city'        => 'San Francisco',
                'country'     => 'US',
                'postal_code' => '94111',
            ],
            'display_name' => 'My First Store',
        ]);

        $locations = $this->stripe->terminal()->locations()->all();

        $this->assertNotEmpty($locations['data']);
        $this->assertInternalType('array', $locations['data']);
    }
}
