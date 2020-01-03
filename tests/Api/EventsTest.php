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
 * @version    2.4.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class EventsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_retrieve_a_single_and_all_events()
    {
        $this->createCustomer();

        $events = $this->stripe->events()->all();

        $this->assertNotEmpty($events['data']);
        $this->assertInternalType('array', $events['data']);

        $event = $this->stripe->events()->find($events['data'][0]['id']);
    }
}
