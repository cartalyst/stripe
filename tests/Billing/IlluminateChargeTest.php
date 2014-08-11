<?php namespace Cartalyst\Stripe\Tests\Billing;
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
use Cartalyst\Stripe\Billing\Models\IlluminateCharge;

class IlluminateChargeTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_check_that_a_charge_is_refunded()
	{
		$refunds = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');
		$refunds->shouldReceive('getResults')->once()->andReturn($refunds);
		$refunds->shouldReceive('count')->once()->andReturn(2);

		$charge = m::mock('Cartalyst\Stripe\Billing\Models\IlluminateCharge[refunds]');
		$charge->shouldReceive('refunds')->andReturn($refunds);
		$charge->refunded = true;

		$this->assertTrue($charge->isRefunded());
	}

	/** @test */
	public function it_can_check_that_a_charge_is_partially_refunded()
	{
		$refunds = m::mock('Illuminate\Database\Eloquent\Relations\BelongsTo');
		$refunds->shouldReceive('getResults')->once()->andReturn($refunds);
		$refunds->shouldReceive('count')->once()->andReturn(2);

		$charge = m::mock('Cartalyst\Stripe\Billing\Models\IlluminateCharge[refunds]');
		$charge->shouldReceive('refunds')->andReturn($refunds);

		$this->assertTrue($charge->isPartialRefunded());
	}

	/** @test */
	public function it_can_check_that_a_charge_is_captured()
	{
		$charge = new IlluminateCharge;
		$charge->captured = true;

		$this->resolver($charge);

		$charge->save();

		$this->assertTrue($charge->isCaptured());
	}

	/** @test */
	public function it_can_check_that_a_charge_is_not_captured()
	{
		$charge = new IlluminateCharge;
		$charge->captured = false;

		$this->resolver($charge);

		$charge->save();

		$this->assertFalse($charge->isCaptured());
	}

	/** @test */
	public function it_can_check_that_a_charge_can_be_captured()
	{
		$charge = new IlluminateCharge;
		$charge->captured = false;
		$charge->failed = false;

		$this->resolver($charge);

		$charge->save();

		$this->assertTrue($charge->canBeCaptured());
	}

	/** @test */
	public function it_can_check_that_a_charge_is_paid()
	{
		$charge = new IlluminateCharge;
		$charge->paid = true;

		$this->resolver($charge);

		$charge->save();

		$this->assertTrue($charge->isPaid());
	}

	/** @test */
	public function it_can_check_that_a_charge_is_not_paid()
	{
		$charge = new IlluminateCharge;
		$charge->paid = false;

		$this->resolver($charge);

		$charge->save();

		$this->assertFalse($charge->isPaid());
	}

	/** @test */
	public function it_can_get_the_invoice_relationship()
	{
		$charge = new IlluminateCharge;

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasOne',
			$charge->invoice()
		);
	}

	/** @test */
	public function it_can_get_the_invoice_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoice',
			IlluminateCharge::getInvoiceModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_invoice_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceModel';

		$charge = new IlluminateCharge;
		$charge->setInvoiceModel($modelClassName);

		$this->assertEquals($modelClassName, $charge->getInvoiceModel());
	}

	/** @test */
	public function it_can_get_the_refunds_relationship()
	{
		$charge = new IlluminateCharge;

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\Hasmany',
			$charge->refunds()
		);
	}

	/** @test */
	public function it_can_get_the_refund_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund',
			IlluminateCharge::getRefundModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_refund_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeRefundModel';

		$charge = new IlluminateCharge;
		$charge->setRefundModel($modelClassName);

		$this->assertEquals($modelClassName, $charge->getRefundModel());
	}

	protected function resolver(&$charge)
	{
		$charge->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$charge->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$charge->getConnection()->shouldReceive('getPostProcessor')->andReturn($processor = m::mock('Illuminate\Database\Query\Processors\Processor'));
		$charge->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');
		$charge->getConnection()->getQueryGrammar()->shouldReceive('compileInsertGetId');
		$processor->shouldReceive('processInsertGetId')->andReturn(1);
	}

}
