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
use Cartalyst\Stripe\Filters\Boolean;

class BooleanTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_convert_booleans()
    {
        $this->assertEquals('true', Boolean::convert(1));
        $this->assertEquals('true', Boolean::convert(true));

        $this->assertEquals('false', Boolean::convert(0));
        $this->assertEquals('false', Boolean::convert(false));
    }
}
