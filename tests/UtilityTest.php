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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use Cartalyst\Stripe\Stripe;
use Cartalyst\Stripe\Utility;
use PHPUnit_Framework_TestCase;

class UtilityTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_build_the_query_for_the_request()
    {
        $this->assertSame('bool=true', Utility::buildQuery([ 'bool' => true ]));
        $this->assertSame('bool=true', Utility::buildQuery([ 'bool' => 'true' ]));

        $this->assertSame('bool=false', Utility::buildQuery([ 'bool' => false ]));
        $this->assertSame('bool=false', Utility::buildQuery([ 'bool' => 'false' ]));
    }
}
