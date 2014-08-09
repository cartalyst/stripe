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
		$billable->stripe_id = 1;
		$this->assertTrue($billable->isBillable());
	}

	/** @test */
	public function it_can_get_the_card_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateCard',
			BillableTraitStub::getCardModel()
		);
	}

	/** @test */
	public function it_can_set_the_card_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\CardModel';

		BillableTraitStub::setCardModel($modelClassName);

		$this->assertEquals($modelClassName, BillableTraitStub::getCardModel());

		$this->assertEquals('cards', (new $modelClassName)->getTable());
	}

	/** @test */
	public function it_can_check_if_the_entity_has_any_active_card()
	{
		$mock = m::mock('BillableTraitStub');
		$mock->shouldReceive('hasActiveCard')->once()->andReturn(true);

		$this->assertTrue($mock->hasActiveCard());
	}

	/** @test */
	public function it_can_check_if_the_entity_doesnt_have_any_active_card()
	{
		$mock = m::mock('BillableTraitStub');
		$mock->shouldReceive('hasActiveCard')->once()->andReturn(false);

		$this->assertFalse($mock->hasActiveCard());
	}

	/** @test */
	public function it_can_get_the_charge_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateCharge',
			BillableTraitStub::getChargeModel()
		);
	}

	/** @test */
	public function it_can_set_the_charge_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\ChargeModel';

		BillableTraitStub::setChargeModel($modelClassName);

		$this->assertEquals($modelClassName, BillableTraitStub::getChargeModel());

		$this->assertEquals('payments', (new $modelClassName)->getTable());
	}

	/** @test */
	public function it_can_get_the_invoice_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoice',
			BillableTraitStub::getInvoiceModel()
		);
	}

	/** @test */
	public function it_can_set_the_invoice_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceModel';

		BillableTraitStub::setInvoiceModel($modelClassName);

		$this->assertEquals($modelClassName, BillableTraitStub::getInvoiceModel());

		$this->assertEquals('invoices', (new $modelClassName)->getTable());
	}

	/** @test */
	public function it_can_get_the_invoice_items_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem',
			BillableTraitStub::getInvoiceItemModel()
		);
	}

	/** @test */
	public function it_can_set_the_invoice_item_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\InvoiceItemModel';

		BillableTraitStub::setInvoiceItemModel($modelClassName);

		$this->assertEquals($modelClassName, BillableTraitStub::getInvoiceItemModel());

		$this->assertEquals('invoice_items', (new $modelClassName)->getTable());
	}

	/** @test */
	public function it_can_get_the_subscription_model()
	{
		$this->assertEquals(
			'Cartalyst\Stripe\Billing\Models\IlluminateSubscription',
			BillableTraitStub::getSubscriptionModel()
		);
	}

	/** @test */
	public function it_can_set_the_subscription_model()
	{
		$modelClassName = 'Cartalyst\Stripe\Tests\Billing\Stubs\SubscriptionModel';

		BillableTraitStub::setSubscriptionModel($modelClassName);

		$this->assertEquals($modelClassName, BillableTraitStub::getSubscriptionModel());

		$this->assertEquals('subscriptions', (new $modelClassName)->getTable());
	}

	/** @test */
	public function it_can_check_if_the_entity_is_subscribed()
	{
		$mock = m::mock('BillableTraitStub');
		$mock->shouldReceive('isSubscribed')->once()->andReturn(true);

		$this->assertTrue($mock->isSubscribed());
	}

	/** @test */
	public function it_can_check_if_the_entity_is_not_subscribed()
	{
		$mock = m::mock('BillableTraitStub');
		$mock->shouldReceive('isSubscribed')->once()->andReturn(false);

		$this->assertFalse($mock->isSubscribed());
	}

	public function it_can_apply_a_coupon_on_the_entity()
	{

	}

	public function it_can_sync_with_stripe()
	{

	}

	public function it_can_get_the_stripe_api_client()
	{

	}

}
