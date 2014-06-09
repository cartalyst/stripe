# Webhooks

Listening to Stripe notification events (Webhooks) is incredible easy and you can listen to any notification that Stripe sends.

## Setup

First create a new controller somewhere inside your application that extends our `Cartalyst\Stripe\WebhookController` controller.

```php
<?php

class WebhookController extends Cartalyst\Stripe\WebhookController {

}
```

Now you need to register a `post` route that points to your controller:

```php
Route::post('webhook/stripe', 'WebhookController@handleWebhook');
```

## Handling events

Now you just need to create the event listeners inside your controller, we have a few examples prepared below:

```php
<?php

use Carbon\Carbon;

class WebhookController extends Cartalyst\Stripe\WebhookController {

	/**
	 * Handles a successful payment.
	 *
	 * @param  array  $payload
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function chargeSucceeded($payload)
	{
		$this->handlePayment($payload);

		return $this->sendResponse('Webhook successfully handled.');
	}

	/**
	 * Handles a failed payment.
	 *
	 * @param  array  $payload
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function chargeFailed($payload)
	{
		$this->handlePayment($payload);

		return $this->sendResponse('Webhook successfully handled.');
	}

	/**
	 * Handles the payment event.
	 *
	 * @param  array  $payload
	 * @return \Cartalyst\Stripe\Charge\IlluminateCharge
	 */
	protected function handlePayment($payload)
	{
		$entity = $this->getBillable($payload['customer']);

		if ( ! $charge = $entity->charges()->where('stripe_id', $chargeId)->first())
		{
			$charge = $entity
				->charges()
				->create([
					'stripe_id'  => $chargeId,
					'amount'     => $payload['amount'],
					'paid'       => $payload['paid'],
					'refunded'   => $payload['refunded'],
					'created_at' => Carbon::createFromTimestamp($payload['created']),
				]);
		}
		else
		{
			$charge->update([
				'paid'     => $payload['paid'],
				'refunded' => $payload['refunded'],
			]);
		}

		return $charge;
	}

}
```

> **Note:** The methods naming are camelCased, example, Stripe sends an event called `charge.failed` we then convert it to `chargeFailed`.
