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
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class StripeTest extends PHPUnit_Framework_TestCase {

	/**
	 * The Stripe API client instance.
	 *
	 * @var \Cartalyst\Stripe\Stripe
	 */
	protected $stripe;

	/**
	 * Setup resources and dependencies
	 *
	 * @return void
	 */
	public function setUp()
	{
		$this->stripe = new Stripe('stripe-api-key', '2014-06-17');
	}

	/** @test */
	public function it_can_create_a_new_instance_using_the_make_method()
	{
		Stripe::make('stripe-api-key');
	}

	/** @test */
	public function it_can_get_the_current_package_version()
	{
		$this->stripe->getVersion();
	}

	/** @test */
	public function it_can_get_and_set_the_api_key()
	{
		$this->assertEquals('stripe-api-key', $this->stripe->getApiKey());

		$this->stripe->setApiKey('my-stripe-key');

		$this->assertEquals('my-stripe-key', $this->stripe->getApiKey());
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function it_throws_an_exception_when_the_api_is_not_set()
	{
		new Stripe;
	}

	/** @test */
	public function it_can_get_and_set_the_api_version()
	{
		$this->assertEquals('2014-06-17', $this->stripe->getApiVersion());

		$this->stripe->setApiVersion('2014-01-01');

		$this->assertEquals('2014-01-01', $this->stripe->getApiVersion());
	}

	/** @test */
	public function it_can_get_and_set_the_client_headers()
	{
		$this->stripe->setHeaders([
			'some-header' => 'foo-bar',
		]);

		$headers = $this->stripe->getHeaders();

		$expected = [
			'some-header' => 'foo-bar',
		];

		$this->assertEquals($headers, $expected);
	}

	public function check_a_single_api_request()
	{
		# $this->stripe->customer(:customerId);
	}

	public function check_a_iterator_api_request()
	{
		# $this->stripe->customersIterator();
	}

	public function check_a_normal_api_request()
	{
		# $this->stripe->customers()->all();
	}

}
