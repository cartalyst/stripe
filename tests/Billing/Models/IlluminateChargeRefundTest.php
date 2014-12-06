<?php namespace Cartalyst\Stripe\Tests\Billing\Models;
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
use Cartalyst\Stripe\Models\IlluminateChargeRefund;

class IlluminateChargeRefundTest extends PHPUnit_Framework_TestCase {

	/**
	 * Close mockery.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		m::close();
	}

	/** @test */
	public function it_can_get_the_charge_relationship()
	{
		$charge = new IlluminateChargeRefund;

		$charge->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$charge->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$charge->getConnection()->shouldReceive('getPostProcessor')->andReturn(m::mock('Illuminate\Database\Query\Processors\Processor'));

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\BelongsTo',
			$charge->charge()
		);
	}

	/** @test */
	public function it_can_get_the_refund_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Models\IlluminateCharge',
			IlluminateChargeRefund::getChargeModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_charge_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeModel';

		$charge = new IlluminateChargeRefund;
		$charge->setChargeModel($modelClassName);

		$this->assertEquals($modelClassName, $charge->getChargeModel());
	}

}
