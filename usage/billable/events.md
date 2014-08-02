### Events

On this section we have a list of all the events fired by the Stripe package that you can listen for.

Event                                 | Parameters                        | Description
------------------------------------- | --------------------------------- | --------------------------------------------
cartalyst.stripe.card.created         | $entity, $response, $card         | Event fired when a new credit card is attached to the entity.
cartalyst.stripe.card.updated         | $entity, $response, $card         | Event fired when an existing credit card is updated.
cartalyst.stripe.card.deleted         | $entity, $response                | Event fired when an existing credit card is deleted.
cartalyst.stripe.charge.created       | $entity, $response, $charge       | Event fired when a new charge is created.
cartalyst.stripe.charge.updated       | $entity, $response, $charge       | Event fired when an existing charge is updated.
cartalyst.stripe.charge.captured      | $entity, $response, $charge       | Event fired when an existing charge is refunded.
cartalyst.stripe.charge.refunded      | $entity, $response, $charge       | Event fired when an existing charge is captured.
cartalyst.stripe.invoice.created      | $entity, $response, $invoice      | Event fired when a new invoice is attached to the entity.
cartalyst.stripe.invoice.updated      | $entity, $response, $invoice      | Event fired when an existing invocie is updated.
cartalyst.stripe.invoice.paid         | $entity, $response, $invoice      | Event fired when an existing invocie is paid.
cartalyst.stripe.invoice.item.created | $entity, $response, $item         | Event fired when a new invoice item is created.
cartalyst.stripe.invoice.item.updated | $entity, $response, $item         | Event fired when an existing invoice item is updated.
cartalyst.stripe.invoice.item.deleted | $entity, $response                | Event fired when an existing invoice item is deleted.
cartalyst.stripe.subscription.created | $entity, $response, $subscription | Event fired when a new subscription is attached to the entity.
cartalyst.stripe.subscription.updated | $entity, $response, $subscription | Event fired when an existing subscription is updated.
cartalyst.stripe.subscription.updated | $entity, $response, $subscription | Event fired when an existing subscription is canceled.
cartalyst.stripe.subscription.resumed | $entity, $response, $subscription | Event fired when an existing subscription is resumed.

> **Note:** Please refer to the list below for the full event `parameter` object namespace.

Parameter     | Response
------------- | ----------------------------------------------------------------
$entity       | Cartalyst\Stripe\Billing\BillingInterface
$response     | Cartalyst\Stripe\Api\Response
$card         | Cartalyst\Stripe\Billing\Models\IlluminateCard
$charge       | Cartalyst\Stripe\Billing\Models\IlluminateCharge
$invoice      | Cartalyst\Stripe\Billing\Models\IlluminateInvoice
$item         | Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
$subscription | Cartalyst\Stripe\Billing\Models\IlluminateSubscription

#### Examples

Whenever a new subscription is attached to an entity.

```php
use Cartalyst\Stripe\Api\Response;
use Cartalyst\Stripe\Billing\BillingInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateSubscription;

Event::listen('cartalyst.stripe.subscription.created', function(BillingInterface $entity, Response $response, IlluminateSubscription $subscription)
{
	// Apply your own logic here
});
```

Whenever an existing subscription is canceled.

```php
use Cartalyst\Stripe\Api\Response;
use Cartalyst\Stripe\Billing\BillingInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateSubscription;

Event::listen('cartalyst.stripe.subscription.canceled', function(BillingInterface $entity, Response $response, IlluminateSubscription $subscription)
{
	// Apply your own logic here
});
```

Whenever an existing subscription is resumed.

```php
use Cartalyst\Stripe\Api\Response;
use Cartalyst\Stripe\Billing\BillingInterface;
use Cartalyst\Stripe\Billing\Models\IlluminateSubscription;

Event::listen('cartalyst.stripe.subscription.resumed', function(BillingInterface $entity, Response $response, IlluminateSubscription $subscription)
{
	// Apply your own logic here
});
```
