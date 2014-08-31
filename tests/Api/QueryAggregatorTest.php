<?php namespace Cartalyst\Stripe\Tests\Api;
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

use Guzzle\Http\QueryString;
use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\Api\QueryAggregator;

class QueryAggregatorTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_can_test_the_aggregate_method()
	{
		$query = new QueryString();

		$aggregator = new QueryAggregator();

		$result = $aggregator->aggregate(
			'expand',
			[
				'customer', 'invoice',
			],
			$query
		);

		$expected[$query->encodeValue('expand[]')] = ['customer', 'invoice'];

		$this->assertEquals($expected, $result);


		$result = $aggregator->aggregate(
			'card',
			[
				'name' => 'foo',
				'ccv'  => '123',
			],
			$query
		);

		$expected = [
			$query->encodeValue('card[name]') => 'foo',
			$query->encodeValue('card[ccv]')  => '123',
		];

		$this->assertEquals($expected, $result);
	}

}
