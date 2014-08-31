<?php namespace Cartalyst\Stripe\Tests\Laravel;
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
use ReflectionClass;
use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\Laravel\StripeServiceProvider;

class StripeServiceProviderTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_can_check_if_the_class_is_a_service_provider()
	{
		$provider = new ReflectionClass('Illuminate\Support\ServiceProvider');

		$reflection = new ReflectionClass('Cartalyst\Stripe\Laravel\StripeServiceProvider');

		$this->assertTrue($reflection->isSubclassOf($provider));
	}

	// public function testFoo()
	// {
	// 	$app = m::mock('Illuminate\Container\Container[bindShared]');

	// 	$app
	// 		->shouldReceive('bindShared')
	// 		->once()
	// 		->with('stripe', m::type('Closure'))
	// 		->andReturnUsing(function ($n, $c) use ($app)
	// 		{
	// 			$app[$n] = $c($app);
	// 		});

	// 	$stub = new StripeServiceProvider($app);

	// 	$this->assertNull($stub->register());

	// 	$this->assertInstanceOf('Cartalyst\Stripe\Api\Stripe', $app['stripe']);

	// }

	/** @test */
	public function it_can_get_the_provides_list()
	{
		$stub = new StripeServiceProvider(null);

		$this->assertContains('stripe', $stub->provides());
	}

}
