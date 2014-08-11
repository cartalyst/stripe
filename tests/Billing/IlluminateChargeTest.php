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
	public function it_can_check_that_a_charge_is_fully_refunded()
	{

	}

	/** @test */
	public function it_can_check_that_a_charge_is_partially_refunded()
	{

	}

	/** @test */
	public function it_can_check_that_a_charge_can_be_captured()
	{

	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
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
	public function it_can_get_the_refund_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund',
			IlluminateCharge::getRefundModel()
		);
	}

}
