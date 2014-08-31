<?php namespace Cartalyst\Stripe\Tests\Api\Exception;
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
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use PHPUnit_Framework_TestCase;
use Guzzle\Http\Message\Response;
use Cartalyst\Stripe\Api\Exception\BadRequestException;

class BadRequestExceptionTest extends PHPUnit_Framework_TestCase {

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

		$response = new Response(400);
		$response->setBody('');

		$exception = BadRequestException::fromCommand($command, $response);

		$this->assertInstanceOf(
			'Cartalyst\Stripe\Api\Exception\BadRequestException',
			$exception
		);
	}

}
