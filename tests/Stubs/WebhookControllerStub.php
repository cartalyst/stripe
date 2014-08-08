<?php namespace Cartalyst\Stripe\Tests\Stubs;

class WebhookControllerStub extends \Cartalyst\Stripe\WebhookController {

	public function handleChargeSucceeded()
	{
		$_SERVER['__stripe_event_id'] = 'foobar';

		$_SERVER['__stripe_event_type'] = 'foo.bar';

		return $this->sendResponse('Handled');
	}

}
