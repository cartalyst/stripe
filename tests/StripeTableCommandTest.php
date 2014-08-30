<?php namespace Cartalyst\Stripe\Tests;
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

use Mockery as m;
use PHPUnit_Framework_TestCase;

class StripeTableCommandTest extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	public function testFoo()
	{
		$cmd = m::mock("Cartalyst\Stripe\StripeTableCommand[argument, send]");

		$cmd
			->shouldReceive('argument')
			->with('table')
			->andReturn('users');

		$cmd
			->shouldReceive('argument')
			->with('from_version')
			->andReturn(null);

		$cmd
			->shouldReceive('argument')
			->with('to_version')
			->andReturn(null);

		$cmd->fire();
	}

}
