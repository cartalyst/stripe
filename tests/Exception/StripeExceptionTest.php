<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Exception;

use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\Exception\StripeException;

class StripeExceptionTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_set_and_get_the_request()
    {
        $exception = new StripeException;
        $exception->setRequest(
            $this->getMock('Guzzle\Http\Message\Request', [], [], '', false)
        );

        $this->assertInstanceOf(
            'Guzzle\Http\Message\Request',
            $exception->getRequest()
        );
    }

    /** @test */
    public function it_can_set_and_get_the_response()
    {
        $exception = new StripeException;
        $exception->setResponse(
            $this->getMock('Guzzle\Http\Message\Response', [], [], '', false)
        );

        $this->assertInstanceOf(
            'Guzzle\Http\Message\Response',
            $exception->getResponse()
        );
    }

    /** @test */
    public function it_can_set_and_get_the_error_type()
    {
        $exception = new StripeException;
        $exception->setErrorType('foo');

        $this->assertEquals('foo', $exception->getErrorType());
    }
}
