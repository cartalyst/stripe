## Events

On this section we have a list of all the events fired by the Stripe package that you can listen for.

Event                                  | Parameters             | Description
-------------------------------------- | ---------------------- | --------------
cartalyst.stripe.card.created          | $entity, $card         | Event fired when a new credit card is attached to an entity.
cartalyst.stripe.card.updated          | $entity, $card         | Event fired when an existing credit card is updated.
cartalyst.stripe.card.deleted          | $entity, $card         | Event fired when an existing credit card is deleted.
cartalyst.stripe.charge.created        | $entity, $charge       | Event fired when a new charge is created.
cartalyst.stripe.charge.updated        | $entity, $charge       | Event fired when an existing charge is updated.
cartalyst.stripe.charge.refunded       | $entity, $charge       | Event fired when an existing charge is refunded.
cartalyst.stripe.charge.captured       | $entity, $charge       | Event fired when an existing charge is captured.
cartalyst.stripe.subscription.created  | $entity, $subscription | Event fired when a new subscription is attached to an entity.
cartalyst.stripe.subscription.updated  | $entity, $subscription | Event fired when an existing subscription is updated.
cartalyst.stripe.subscription.canceled | $entity, $subscription | Event fired when an existing subscription is canceled.
cartalyst.stripe.subscription.resumed  | $entity, $subscription | Event fired when an existing subscription is resumed.

### Examples

Whenever a new subscription is attached to an entity.

```php
Event::listen('cartalyst.stripe.subscription.created', function($entity, $subscription)
{
	// Apply your own logic here
});
```

Whenever an existing subscription is canceled.

```php
Event::listen('cartalyst.stripe.subscription.canceled', function($entity, $subscription)
{
	// Apply your own logic here
});
```

Whenever an existing subscription is resumed.

```php
Event::listen('cartalyst.stripe.subscription.resumed', function($entity, $subscription)
{
	// Apply your own logic here
});
```
