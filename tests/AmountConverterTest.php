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

use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\AmountConverter;

class AmountConverterTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_convert_a_number_to_cents()
    {
        $this->assertSame('1200', AmountConverter::convert(12.00));
        $this->assertSame('1200', AmountConverter::convert('12.00'));

        $this->assertSame('1201', AmountConverter::convert(12.01));
        $this->assertSame('1201', AmountConverter::convert('12.01'));

        $this->assertSame('1270', AmountConverter::convert(12.70));
        $this->assertSame('1270', AmountConverter::convert('12.70'));

        $this->assertSame('1290', AmountConverter::convert(12.90));
        $this->assertSame('1290', AmountConverter::convert('12.90'));

        $this->assertSame('1299', AmountConverter::convert(12.99));
        $this->assertSame('1299', AmountConverter::convert('12.99'));

        $this->assertSame('1299', AmountConverter::convert(1299));
        $this->assertSame('1299', AmountConverter::convert('1299'));

        $this->assertSame('1299.3', AmountConverter::convert(12.993));
        $this->assertSame('1299.3', AmountConverter::convert('12.993'));

        $this->assertSame('129950', AmountConverter::convert(1299.5));
        $this->assertSame('129950', AmountConverter::convert('1299.5'));
    }
}
