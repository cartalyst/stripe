<?php namespace Cartalyst\Stripe\Tests\Billing\Gateways;
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

class CardGatewayTest extends PHPUnit_Framework_TestCase {

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
	public function it_can_create_a_new_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_update_a_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_delete_a_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_make_an_existing_card_the_default_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_set_a_new_card_the_default_card()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/** @test */
	public function it_can_syncronize_the_entity_cards_with_stripe()
	{
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

}
