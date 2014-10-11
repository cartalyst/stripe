<?php namespace Cartalyst\Stripe\Tests\Stubs;
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

class WebhookControllerStub extends \Cartalyst\Stripe\WebhookController {

	public function handleChargeSucceeded()
	{
		$_SERVER['__stripe_event_id'] = 'foobar';

		$_SERVER['__stripe_event_type'] = 'foo.bar';

		return $this->sendResponse('Handled');
	}

	public function handleDummyEvent()
	{
		$this->nullableTimestamp(123);
	}

}
