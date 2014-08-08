## Webhooks

Listening to Stripe notification events (Webhooks) is incredible easy and you can listen to any notification that Stripe sends.

#### Setup

First create a new controller somewhere inside your application that extends our `Cartalyst\Stripe\WebhookController` controller.

```php
<?php namespace Acme\Controllers;

use Cartalyst\Stripe\WebhookController as BaseWebhookController;

class WebhookController extends BaseWebhookController {

}
```

> **Note:** The controller name and namespace is just for the example, you can name and place the controller where it fits best inside your application.

Now you need to register a `post` route that points to your controller:

```php
Route::post('webhook/stripe', 'Acme\Controllers\WebhookController@handleWebhook');
```

> **Note:** The route URI `webhook/stripe` is just for the example, you can choose to use a different one.

#### Handling events

Now you just need to create the notification event handlers inside your controller, we have a few examples prepared below:

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
	public function handleChargeSucceeded($payload)
	{
		$charge = $this->handlePayment($payload);

		// apply your own logic here if required

		return $this->sendResponse('Webhook successfully handled.');
	}

	/**
	 * Handles a failed payment.
	 *
	 * @param  array  $payload
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handleChargeFailed($payload)
	{
		$charge = $this->handlePayment($payload);

		// apply your own logic here if required

		return $this->sendResponse('Webhook successfully handled.');
	}

	/**
	 * Handles a payment refund.
	 *
	 * @param  array  $payload
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handleChargeRefunded($payload)
	{
		$charge = $this->handlePayment($payload);

		// apply your own logic here if required

		return $this->sendResponse('Webhook successfully handled.');
	}

	/**
	 * Handles the payment event.
	 *
	 * @param  array  $charge
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	protected function handlePayment($charge)
	{
		$entity = $this->getBillable($charge['customer']);

		$entity->charge()->syncWithStripe();

		return $entity->charges()->whereStripeId($charge['id'])->first();
	}

}
```

> **Note 1:** The examples above are merely for demonstration, you can apply your own logic for each event notification, we're just showing the power of the synchronization methods the Stripe package has to offer :)

> **Note 2:** Please refer to the list below for all the events that Stripe sends and to know which controller method name you need to use.

#### Types of Events

Stripe Event Name                    | Controller Method Name                 | Description
------------------------------------ | -------------------------------------- | ----------------
account.updated                      | handleAccountUpdated                   | Occurs whenever an account status or property has changed.
account.application.deauthorized     | handleAccountApplicationDeauthorized   | Occurs whenever a user deauthorizes an application. Sent to the related application only.
application_fee.created              | handleApplicationFeeCreated            | Occurs whenever an application fee is created on a charge.
application_fee.refunded             | handleBalanceAvailable                 | Occurs whenever your Stripe balance has been updated (e.g. when a charge collected is available to be paid out). By default, Stripe will automatically transfer any funds in your balance to your bank account on a daily basis.
charge.succeeded                     | handleChargeSucceeded                  | Occurs whenever a new charge is created and is successful.
charge.failed                        | handleChargeFailed                     | Occurs whenever a failed charge attempt occurs.
charge.refunded                      | handleChargeRefunded                   | Occurs whenever a charge is refunded, including partial refunds.
charge.captured                      | handleChargeCaptured                   | Occurs whenever a previously uncaptured charge is captured.
charge.updated                       | handleChargeUpdated                    | Occurs whenever a charge description or metadata is updated.
charge.dispute.created               | handleChargeDisputeCreated             | Occurs whenever a customer disputes a charge with their bank (chargeback).
charge.dispute.updated               | handleChargeDisputeUpdated             | Occurs when the dispute is updated (usually with evidence).
charge.dispute.closed                | handleChargeDisputeClosed              | Occurs when the dispute is resolved and the dispute status changes to won or lost.
customer.created                     | handleCustomerCreated                  | Occurs whenever a new customer is created.
customer.updated                     | handleCustomerUpdated                  | Occurs whenever any property of a customer changes.
customer.deleted                     | handleCustomerDeleted                  | Occurs whenever a customer is deleted.
customer.card.created                | handleCustomerCardCreated              | Occurs whenever a new card is created for the customer.
customer.card.updated                | handleCustomerCardUpdated              | Occurs whenever a card's details are changed.
customer.card.deleted                | handleCustomerCardDeleted              | Occurs whenever a card is removed from a customer.
customer.subscription.created        | handleCustomerSubscriptionCreated      | Occurs whenever a customer with no subscription is signed up for a plan.
customer.subscription.updated        | handleCustomerSubscriptionUpdated      | Occurs whenever a subscription changes. Examples would include switching from one plan to another, or switching status from trial to active.
customer.subscription.deleted        | handleCustomerSubscriptionDeleted      | Occurs whenever a customer ends their subscription.
customer.subscription.trial_will_end | handleCustomerSubscriptionTrialWillEnd | Occurs three days before the trial period of a subscription is scheduled to end.
customer.discount.created            | handleCustomerDiscountCreated          | Occurs whenever a coupon is attached to a customer.
customer.discount.updated            | handleCustomerDiscountUpdated          | Occurs whenever a customer is switched from one coupon to another.
customer.discount.deleted            | handleCustomerDiscountDeleted          | Occurs whenever a customer's discount is removed.
invoice.created                      | handleInvoiceCreated                   | Occurs whenever a new invoice is created. If you are using webhooks, Stripe will wait one hour after they have all succeeded to attempt to pay the invoice; the only exception here is on the first invoice, which gets created and paid immediately when you subscribe a customer to a plan. If your webhooks do not all respond successfully, Stripe will continue retrying the webhooks every hour and will not attempt to pay the invoice. After 3 days, Stripe will attempt to pay the invoice regardless of whether or not your webhooks have succeeded. See how to respond to a webhook.
invoice.updated                      | handleInvoiceUpdated                   | Occurs whenever an invoice changes (for example, the amount could change).
invoice.payment_succeeded            | handleInvoicePaymentSucceeded          | Occurs whenever an invoice attempts to be paid, and the payment succeeds.
invoice.payment_failed               | handleInvoicePaymentFailed             | Occurs whenever an invoice attempts to be paid, and the payment fails. This can occur either due to a declined payment, or because the customer has no active card. A particular case of note is that if a customer with no active card reaches the end of its free trial, an invoice.payment_failed notification will occur.
invoiceitem.created                  | handleInvoiceitemCreated               | Occurs whenever an invoice item is created.
invoiceitem.updated                  | handleInvoiceitemUpdated               | Occurs whenever an invoice item is updated.
invoiceitem.deleted                  | handleInvoiceitemDeleted               | Occurs whenever an invoice item is deleted.
plan.created                         | handlePlanCreated                      | Occurs whenever a plan is created.
plan.updated                         | handlePlanUpdated                      | Occurs whenever a plan is updated.
plan.deleted                         | handlePlanDeleted                      | Occurs whenever a plan is deleted.
coupon.created                       | handleCouponCreated                    | Occurs whenever a coupon is created.
coupon.deleted                       | handleCouponDeleted                    | Occurs whenever a coupon is deleted.
transfer.created                     | handleTransferCreated                  | Occurs whenever a new transfer is created.
transfer.updated                     | handleTransferUpdated                  | Occurs whenever the description or metadata of a transfer is updated.
transfer.paid                        | handleTransferPaid                     | Occurs whenever a sent transfer is expected to be available in the destination bank account. If the transfer failed, a transfer.failed webhook will additionally be sent at a later time.
transfer.failed                      | handleTransferFailed                   | Occurs whenever Stripe attempts to send a transfer and that transfer fails.

### Testing Webhooks

There are situations when we need to test our webhook controller while we're developing it and while pushing the changes to a staging server is a good pratice it's not always the fastest way to test our webhook controller and get the feedback of if it worked properly or not since we'll need to wait for Stripe.com to push the webhook event that will hit your server and you'll need to check either the server logs or Stripe.com Dashboard to see if the webhook was handled successfully.

Below we'll give you two examples on how to test all events or a single event.

#### Single Event

Testing single events is a no brainer, you just need to know the Stripe Event Id.

##### Example

```php
// Fetch the Event payload for the given event id
$payload = Stripe::events()->find([
	'id' => 'evt_4Y2WyIMZdxy9Pg',
])->toArray();

// Instantiate your Webhook Controller
$controller = app('Acme\Controllers\WebhookController');

// Pass in the payload to be handled
$response = $controller->handleWebhook($payload);

var_dump($response);
```

#### Multiple Events

Testing multiple events is similar the single events, you just need to fetch all the events and loop through them, the rest of the logic is very similar.

##### Example

```php
// Instantiate your Webhook Controller
$controller = app('Acme\Controllers\WebhookController');

// Fetch all the events
$events = Stripe::events()->all();

// Loop through the events
foreach ($events['data'] as $payload)
{
	// Pass in the payload to be handled
	$response = $controller->handleWebhook($payload);

	var_dump($response);
}
```
