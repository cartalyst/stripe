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
use Cartalyst\Stripe\Billing\Models\IlluminateInvoice;

class IlluminateInvoiceTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_check_if_an_invoice_has_metadata()
	{
		$metadata = [
			'name' => 'John Doe',
			'email' => 'john.doe@example.com',
		];

		$invoice = new IlluminateInvoice;
		$invoice->metadata = $metadata;

		$this->resolver($invoice);

		$invoice->save();

		$this->assertEquals(2, count($invoice->metadata));
	}

	/** @test */
	public function it_can_check_if_an_invoice_is_closed()
	{
		$invoice = new IlluminateInvoice;
		$invoice->closed = true;

		$this->resolver($invoice);

		$invoice->save();

		$this->assertTrue($invoice->isClosed());
	}

	/** @test */
	public function it_can_check_if_an_invoice_is_paid()
	{
		$invoice = new IlluminateInvoice;
		$invoice->paid = true;

		$this->resolver($invoice);

		$invoice->save();

		$this->assertTrue($invoice->isPaid());
	}

	/** @test */
	public function it_can_get_the_charge_relationship()
	{
		$invoice = new IlluminateInvoice;

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\BelongsTo',
			$invoice->charge()
		);
	}

	/** @test */
	public function it_can_get_the_charge_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateCharge',
			IlluminateInvoice::getChargeModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_charge_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeModel';

		$invoice = new IlluminateInvoice;
		$invoice->setChargeModel($modelClassName);

		$this->assertEquals($modelClassName, $invoice->getChargeModel());
	}

	/** @test */
	public function it_can_get_the_items_relationship()
	{
		$invoice = new IlluminateInvoice;

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasMany',
			$invoice->items()
		);
	}

	/** @test */
	public function it_can_get_the_invoice_item_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem',
			IlluminateInvoice::getInvoiceItemModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_invoice_item_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceItemModel';

		$invoice = new IlluminateInvoice;
		$invoice->setInvoiceItemModel($modelClassName);

		$this->assertEquals($modelClassName, $invoice->getInvoiceItemModel());
	}

	/** @test */
	public function it_can_get_the_subscription_relationship()
	{
		$invoice = new IlluminateInvoice;

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\BelongsTo',
			$invoice->subscription()
		);
	}

	/** @test */
	public function it_can_get_the_subscription_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateSubscription',
			IlluminateInvoice::getSubscriptionModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_subscription_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\SubscriptionModel';

		$invoice = new IlluminateInvoice;
		$invoice->setSubscriptionModel($modelClassName);

		$this->assertEquals($modelClassName, $invoice->getSubscriptionModel());
	}

	protected function resolver(&$invoice)
	{
		$invoice->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$invoice->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$invoice->getConnection()->shouldReceive('getPostProcessor')->andReturn($processor = m::mock('Illuminate\Database\Query\Processors\Processor'));
		$invoice->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');
		$invoice->getConnection()->getQueryGrammar()->shouldReceive('compileInsertGetId');
		$processor->shouldReceive('processInsertGetId')->andReturn(1);
	}

}
