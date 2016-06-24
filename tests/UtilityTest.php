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
 * @version    1.0.10
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use Cartalyst\Stripe\Utility;
use PHPUnit_Framework_TestCase;

class UtilityTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_prepare_the_parameters_for_the_request()
    {
        $this->assertSame([ 'bool' => 'true' ], Utility::prepareParameters([ 'bool' => true ]));
        $this->assertSame([ 'bool' => 'true' ], Utility::prepareParameters([ 'bool' => 'true' ]));

        $this->assertSame([ 'bool' => 'false' ], Utility::prepareParameters([ 'bool' => false ]));
        $this->assertSame([ 'bool' => 'false' ], Utility::prepareParameters([ 'bool' => 'false' ]));

        $this->assertSame([ 'amount' => '012' ], Utility::prepareParameters([ 'amount' => 0.12 ]));
        $this->assertSame([ 'amount' => '1200' ], Utility::prepareParameters([ 'amount' => 12.00 ]));
        $this->assertSame([ 'amount' => '1299' ], Utility::prepareParameters([ 'amount' => 12.99 ]));

        $this->assertSame([ 'price' => '012' ], Utility::prepareParameters([ 'price' => 0.12 ]));
        $this->assertSame([ 'price' => '1200' ], Utility::prepareParameters([ 'price' => 12.00 ]));
        $this->assertSame([ 'price' => '1299' ], Utility::prepareParameters([ 'price' => 12.99 ]));
    }
}
