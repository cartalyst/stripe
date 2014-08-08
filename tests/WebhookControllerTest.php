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

use PHPUnit_Framework_TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Request;
use Cartalyst\Stripe\Tests\Stubs\WebhookControllerStub;

class WebhookControllerTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup resources and dependencies
	 *
	 * @return void
	 */
	public function setUp()
	{
		Facade::clearResolvedInstances();
	}

	/** @test */
	public function it_can_call_the_approriate_method_based_on_the_stripe_event()
	{
		$_SERVER['__stripe_event_id'] = null;

		Request::shouldReceive('getContent')->andReturn(json_encode([
			'type' => 'charge.succeeded',
			'data' => [
				'object' => [
					'id' => 'foobar',
				],
			],
		]));

		$controller = new WebhookControllerStub;
		$response = $controller->handleWebhook();

		$this->assertEquals($_SERVER['__stripe_event_id'], 'foobar');

		$this->assertEquals($_SERVER['__stripe_event_type'], 'foo.bar');

		$this->assertEquals($response->getContent(), 'Handled');
	}

	/** @test */
	public function it_can_pass_with_non_existing_methods()
	{
		Request::shouldReceive('getContent')->andReturn(json_encode(['type' => 'foo.bar']));

		$controller = new WebhookControllerStub;
		$response = $controller->handleWebhook();

		$this->assertEquals($response->getContent(), null);
	}

	/** @test */
	public function it_can_pass_the_payload_through_the_handle_webhook_method()
	{
		$payload = [
			'type' => 'charge.succeeded',
			'data' => [
				'object' => [
					'id' => 'foobar',
				],
			],
		];

		$controller = new WebhookControllerStub;
		$response = $controller->handleWebhook($payload);

		$this->assertEquals($_SERVER['__stripe_event_id'], 'foobar');

		$this->assertEquals($_SERVER['__stripe_event_type'], 'foo.bar');

		$this->assertEquals($response->getContent(), 'Handled');

	}

}
