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
 * @version    2.2.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class EphemeralKey extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_ephemeral_key()
    {
        $customer = $this->createCustomer();

        $ephemeralKey = $this->stripe->ephemeralKey()->create($customer['id']);

        $this->assertArrayHasKey('secret', $ephemeralKey);
        $this->assertSame($customer['id'], $ephemeralKey['associated_objects'][0]['id']);
    }

    /** @test */
    public function it_can_delete_an_ephemeral_key()
    {
        $customer = $this->createCustomer();

        $ephemeralKey = $this->stripe->ephemeralKey()->create($customer['id']);

        $ephemeralKey = $this->stripe->ephemeralKey()->delete($ephemeralKey['id']);

        $this->assertArrayNotHasKey('secret', $ephemeralKey);
        $this->assertSame($customer['id'], $ephemeralKey['associated_objects'][0]['id']);
    }
}
