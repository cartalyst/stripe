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
 * @version    2.2.11
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Terminal;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

// TODO: This functionality is not working at the moment. Stripe was already contacted, will review this once i hear back
class ReadersTest_ extends FunctionalTestCase
{
    // /** @test */
    // public function it_can_create_a_new_reader()
    // {
    //     $location = $this->stripe->terminal()->locations()->create([
    //         'address' => [
    //             'line1'       => '1234 Main Street',
    //             'city'        => 'San Francisco',
    //             'country'     => 'US',
    //             'postal_code' => '94111',
    //         ],
    //         'display_name' => 'My First Store',
    //     ]);

    //     $reader = $this->stripe->terminal()->readers()->create([
    //         'registration_code' => 'a-registration-code',
    //         'label' => 'Location Label',
    //         'location' => $location['id']
    //     ]);

    //     $this->assertSame('Location Label', $reader['label']);
    // }
}
