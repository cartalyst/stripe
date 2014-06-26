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

use Cartalyst\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class StripeTest extends PHPUnit_Framework_TestCase {

	/**
	 * The Stripe client.
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
		$this->stripe = new Stripe('stripe-api-key', '2014-06-17', __DIR__.'/../manifests');
	}

	/** @test */
	public function it_can_retrieve_the_api_key()
	{
		$this->assertEquals('stripe-api-key', $this->stripe->getStripeKey());
	}

	/** @test */
	public function it_can_set_the_api_key()
	{
		$this->stripe->setStripeKey('my-stripe-key');

		$this->assertEquals('my-stripe-key', $this->stripe->getStripeKey());
	}

	/** @test */
	public function it_can_retrieve_the_api_version()
	{
		$this->assertEquals('2014-06-17', $this->stripe->getVersion());
	}

	/** @test */
	public function it_can_set_the_api_version()
	{
		$this->stripe->setVersion('2014-01-01');

		$this->assertEquals('2014-01-01', $this->stripe->getVersion());
	}

	/** @test */
	public function it_can_retrieve_the_user_agent()
	{
		$this->assertEquals('Cartalyst-Stripe/1.0.0', $this->stripe->getUserAgent());
	}

	/** @test */
	public function it_can_set_the_user_agent()
	{
		$this->stripe->setUserAgent('Foo/Bar');

		$this->assertEquals('Foo/Bar', $this->stripe->getUserAgent());
	}

	/** @test */
	public function it_can_retrieve_the_manifest_path()
	{
		$this->assertEquals(__DIR__.'/../manifests', $this->stripe->getManifestPath());
	}

	/** @test */
	public function it_can_set_the_manifest_path()
	{
		$this->stripe->setManifestPath('foo/bar/baz');

		$this->assertEquals('foo/bar/baz', $this->stripe->getManifestPath());
	}

	/** @test */
	public function it_can_retrieve_the_client_headers()
	{
		$headers = $this->stripe->getHeaders();

		$expected = [
			'Stripe-Version' => '2014-06-17',
		];

		$this->assertEquals($headers, $expected);
	}

	/** @test */
	public function it_can_set_the_client_headers()
	{
		$this->stripe->setHeaders([
			'some-header' => 'foo-bar',
		]);

		$headers = $this->stripe->getHeaders();

		$expected = [
			'some-header'     => 'foo-bar',
			'Stripe-Version' => '2014-06-17',
		];

		$this->assertEquals($headers, $expected);
	}

}
