<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\tests\Filters;

use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\Filters\Number;

class NumberTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_convert_a_number_to_an_integer()
    {
        $this->assertEquals(6000, Number::convert(6000));
        $this->assertEquals(6000, Number::convert(60.00));
        $this->assertEquals(6000, Number::convert('60.00'));

        $this->assertEquals(5543, Number::convert(5543));
        $this->assertEquals(5543, Number::convert(55.43));
        $this->assertEquals(5543, Number::convert('55.43'));

        $this->assertEquals(1249, Number::convert(1249));
        $this->assertEquals(1249, Number::convert(12.49));
        $this->assertEquals(1249, Number::convert('12.49'));
    }
}
