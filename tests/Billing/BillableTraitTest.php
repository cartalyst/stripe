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
use Cartalyst\Stripe\Tests\Billing\Stubs\BillableTraitStub;

class BillableTraitTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_get_the_entity_stripe_id()
	{
		$billable = new BillableTraitStub;
		$billable->stripe_id = null;
		$this->assertNull($billable->getStripeId());

		$billable = new BillableTraitStub;
		$billable->stripe_id = 'foo';
		$this->assertEquals('foo', $billable->getStripeId());
	}

	/** @test */
	public function it_can_check_if_the_entity_is_ready_to_be_billed()
	{
		$billable = new BillableTraitStub;
		$billable->stripe_id = null;
		$this->assertFalse($billable->isBillable());

		$billable = new BillableTraitStub;
		$billable->stripe_id = 'foo';
		$this->assertTrue($billable->isBillable());
	}

	/** @test */
	public function it_can_get_the_cards_relationship()
	{
		$entity = new BillableTraitStub;

		$this->resolver($entity);

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasMany',
			$entity->cards()
		);
	}

	/** @test */
	public function it_can_get_the_card_gateway()
	{
		$entity = new BillableTraitStub;

		$this->assertInstanceOf(
			'Cartalyst\Stripe\Billing\Gateways\CardGateway',
			$entity->card()
		);
	}

	/** @test */
	public function it_can_get_the_card_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateCard',
			BillableTraitStub::getCardModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_card_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\CardModel';

		BillableTraitStub::setCardModel($modelClassName);

		$className = BillableTraitStub::getCardModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('cards', (new $className)->getTable());
	}

	/** @test */
	public function it_can_check_if_the_entity_has_any_active_card()
	{
		$mock = m::mock('Cartalyst\Stripe\Tests\Billing\Stubs\BillableTraitStub');
		$mock->shouldReceive('hasActiveCard')->once()->andReturn(true);

		$this->assertTrue($mock->hasActiveCard());
	}

	/** @test */
	public function it_can_check_if_the_entity_doesnt_have_any_active_card()
	{
		$mock = m::mock('Cartalyst\Stripe\Tests\Billing\Stubs\BillableTraitStub');
		$mock->shouldReceive('hasActiveCard')->once()->andReturn(false);

		$this->assertFalse($mock->hasActiveCard());
	}

	/** @test */
	public function it_can_get_the_default_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_update_the_default_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_get_the_charges_relationship()
	{
		$entity = new BillableTraitStub;

		$this->resolver($entity);

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasMany',
			$entity->charges()
		);
	}

	/** @test */
	public function it_can_get_the_charge_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateCharge',
			BillableTraitStub::getChargeModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_charge_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeModel';

		BillableTraitStub::setChargeModel($modelClassName);

		$className = BillableTraitStub::getChargeModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('payments', (new $className)->getTable());
	}

	/** @test */
	public function it_can_get_the_charge_refund_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund',
			BillableTraitStub::getChargeRefundModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_charge_refund_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeRefundModel';

		BillableTraitStub::setChargeRefundModel($modelClassName);

		$className = BillableTraitStub::getChargeRefundModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('payment_refunds', (new $className)->getTable());
	}

	/** @test */
	public function it_can_get_the_invoices_relationship()
	{
		$entity = new BillableTraitStub;

		$this->resolver($entity);

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasMany',
			$entity->invoices()
		);
	}

	/** @test */
	public function it_can_get_the_invoice_gateway()
	{
		$entity = new BillableTraitStub;

		$this->assertInstanceOf(
			'Cartalyst\Stripe\Billing\Gateways\InvoiceGateway',
			$entity->invoice()
		);
	}

	/** @test */
	public function it_can_get_the_invoice_items_gateway()
	{
		$entity = new BillableTraitStub;

		$this->assertInstanceOf(
			'Cartalyst\Stripe\Billing\Gateways\InvoiceItemsGateway',
			$entity->invoice()->items()
		);
	}

	/** @test */
	public function it_can_get_the_upcoming_invoice_items()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_get_the_invoice_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoice',
			BillableTraitStub::getInvoiceModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_invoice_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceModel';

		BillableTraitStub::setInvoiceModel($modelClassName);

		$className = BillableTraitStub::getInvoiceModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('invoices', (new $className)->getTable());
	}

	/** @test */
	public function it_can_get_the_invoice_items_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem',
			BillableTraitStub::getInvoiceItemModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_invoice_item_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceItemModel';

		BillableTraitStub::setInvoiceItemModel($modelClassName);

		$className = BillableTraitStub::getInvoiceItemModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('invoice_items', (new $className)->getTable());
	}

	/** @test */
	public function it_can_get_the_subscriptions_relationship()
	{
		$entity = new BillableTraitStub;

		$this->resolver($entity);

		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Relations\HasMany',
			$entity->subscriptions()
		);
	}

	/** @test */
	public function it_can_get_the_subscription_gateway()
	{
		$entity = new BillableTraitStub;

		$this->assertInstanceOf(
			'Cartalyst\Stripe\Billing\Gateways\SubscriptionGateway',
			$entity->subscription()
		);
	}

	/** @test */
	public function it_can_get_the_subscription_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateSubscription',
			BillableTraitStub::getSubscriptionModel()
		);
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function it_can_set_the_subscription_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\SubscriptionModel';

		BillableTraitStub::setSubscriptionModel($modelClassName);

		$className = BillableTraitStub::getSubscriptionModel();

		$this->assertEquals($modelClassName, $className);

		$this->assertEquals('subscriptions', (new $className)->getTable());
	}

	/** @test */
	public function it_can_check_if_the_entity_is_subscribed()
	{
		$mock = m::mock('Cartalyst\Stripe\Tests\Billing\Stubs\BillableTraitStub');
		$mock->shouldReceive('isSubscribed')->once()->andReturn(true);

		$this->assertTrue($mock->isSubscribed());
	}

	/** @test */
	public function it_can_check_if_the_entity_is_not_subscribed()
	{
		$mock = m::mock('Cartalyst\Stripe\Tests\Billing\Stubs\BillableTraitStub');
		$mock->shouldReceive('isSubscribed')->once()->andReturn(false);

		$this->assertFalse($mock->isSubscribed());
	}

	/** @test */
	public function it_can_apply_a_coupon_on_the_entity()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_sync_with_stripe()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_get_the_stripe_api_client()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	protected function resolver(&$entity)
	{
		$entity->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$entity->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$entity->getConnection()->shouldReceive('getPostProcessor')->andReturn($processor = m::mock('Illuminate\Database\Query\Processors\Processor'));
		$entity->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');
		$entity->getConnection()->getQueryGrammar()->shouldReceive('compileInsertGetId');
		$processor->shouldReceive('processInsertGetId')->andReturn(1);
	}

}
