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

namespace Cartalyst\Stripe\tests\Exception;

use PHPUnit_Framework_TestCase;
use Guzzle\Http\Message\Response;
use Cartalyst\Stripe\Exception\CardErrorException;

class CardErrorExceptionTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_create_the_exception()
    {
        $command = $this->getMock('Guzzle\Service\Command\CommandInterface');
        $command
            ->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue(
                $this->getMock('Guzzle\Http\Message\Request', [], [], '', false)
            ));

        $response = new Response(402);
        $response->setBody('');

        $exception = CardErrorException::fromCommand($command, $response);

        $this->assertInstanceOf(
            'Cartalyst\Stripe\Exception\CardErrorException',
            $exception
        );
    }
}
