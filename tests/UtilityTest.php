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
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2015, Cartalyst LLC
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

        $this->assertSame([ 'amount' => '1299' ], Utility::prepareParameters([ 'amount' => 1299 ]));
        $this->assertSame([ 'amount' => '1200' ], Utility::prepareParameters([ 'amount' => 12.00 ]));
        $this->assertSame([ 'amount' => '1299' ], Utility::prepareParameters([ 'amount' => 12.99 ]));
    }

    /** @test */
    public function it_can_convert_a_number_to_cents()
    {
        $this->assertSame('1200', Utility::convertToCents(12.00));
        $this->assertSame('1200', Utility::convertToCents('12.00'));

        $this->assertSame('1201', Utility::convertToCents(12.01));
        $this->assertSame('1201', Utility::convertToCents('12.01'));

        $this->assertSame('1270', Utility::convertToCents(12.70));
        $this->assertSame('1270', Utility::convertToCents('12.70'));

        $this->assertSame('1290', Utility::convertToCents(12.90));
        $this->assertSame('1290', Utility::convertToCents('12.90'));

        $this->assertSame('1299', Utility::convertToCents(12.99));
        $this->assertSame('1299', Utility::convertToCents('12.99'));

        $this->assertSame('1299', Utility::convertToCents(1299));
        $this->assertSame('1299', Utility::convertToCents('1299'));

        $this->assertSame('1299.3', Utility::convertToCents(12.993));
        $this->assertSame('1299.3', Utility::convertToCents('12.993'));

        $this->assertSame('129950', Utility::convertToCents(1299.5));
        $this->assertSame('129950', Utility::convertToCents('1299.5'));
    }
}
