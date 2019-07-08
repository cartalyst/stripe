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
 * @version    2.2.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Terminal;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class ConnectionTokensTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_connection_token()
    {
        $token = $this->stripe->terminal()->connectionTokens()->create();

        $this->assertNotNull($token['secret']);
    }
}
