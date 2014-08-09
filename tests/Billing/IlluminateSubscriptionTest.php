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
use Cartalyst\Stripe\Billing\Models\IlluminateSubscription;

class IlluminateSubscriptionTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_check_if_a_subscription_is_active()
	{
		$subscription = new IlluminateSubscription;
		$subscription->active = 1;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertTrue($subscription->active);
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_on_trial_period()
	{
		$subscription = new IlluminateSubscription;
		$subscription->period_ends_at = time();
		$subscription->trial_ends_at = time();

		$this->resolver($subscription);

		$subscription->save();

		$this->assertTrue($subscription->onTrialPeriod());
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_not_on_trial_period()
	{
		$subscription = new IlluminateSubscription;
		$subscription->period_ends_at = time();
		$subscription->trial_ends_at = null;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertFalse($subscription->onTrialPeriod());
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_on_grace_period()
	{
		$subscription = new IlluminateSubscription;
		$subscription->canceled_at = time();
		$subscription->ended_at = null;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertTrue($subscription->onGracePeriod());
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_not_on_grace_period()
	{
		$subscription = new IlluminateSubscription;
		$subscription->canceled_at = null;
		$subscription->ended_at = time();

		$this->resolver($subscription);

		$subscription->save();

		$this->assertFalse($subscription->onGracePeriod());
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_canceled()
	{
		$subscription = new IlluminateSubscription;
		$subscription->canceled_at = time();

		$this->resolver($subscription);

		$subscription->save();

		$this->assertTrue($subscription->isCanceled());
	}

	/** @test */
	public function it_can_check_if_a_subscription_is_not_canceled()
	{
		$subscription = new IlluminateSubscription;
		$subscription->canceled_at = null;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertFalse($subscription->isCanceled());
	}

	/** @test */
	public function it_can_check_if_a_subscription_has_expired()
	{
		$subscription = new IlluminateSubscription;
		$subscription->active = 0;
		$subscription->ended_at = time();
		$subscription->canceled_at = null;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertTrue($subscription->isExpired());
	}

	/** @test */
	public function it_can_check_if_a_subscription_has_not_expired()
	{
		$subscription = new IlluminateSubscription;
		$subscription->active = 1;

		$this->resolver($subscription);

		$subscription->save();

		$this->assertFalse($subscription->isExpired());
	}

	protected function resolver(&$subscription)
	{
		$subscription->setConnectionResolver($resolver = m::mock('Illuminate\Database\ConnectionResolverInterface'));
		$resolver->shouldReceive('connection')->andReturn(m::mock('Illuminate\Database\Connection'));
		$subscription->getConnection()->shouldReceive('getQueryGrammar')->andReturn(m::mock('Illuminate\Database\Query\Grammars\Grammar'));
		$subscription->getConnection()->shouldReceive('getPostProcessor')->andReturn($processor = m::mock('Illuminate\Database\Query\Processors\Processor'));
		$subscription->getConnection()->getQueryGrammar()->shouldReceive('getDateFormat')->andReturn('Y-m-d H:i:s');
		$subscription->getConnection()->getQueryGrammar()->shouldReceive('compileInsertGetId');
		$processor->shouldReceive('processInsertGetId')->andReturn(1);
	}

}
