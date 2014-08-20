## Billable Entities

In this section we'll show how you can use the billable entities feature.

> **Note:** A User model will be used for the following examples.

#### $entity->isBillable()

This method is very useful when you need to determine if the entity is ready to be billed, or in other words, if the entity has a Stripe customer already attached.

##### Example

```php
$user = User::find(1);

if ( ! $user->isBillable())
{
	echo "User is not ready to be billed!";
}
```

#### $entity->applyCoupon()

Applies a coupon on the entity, this will execute a Stripe API call to apply the coupon on the Stripe customer that is attached to this entity.

##### Arguments

Key     | Required | Type   | Default | Description
------- | -------- | ------ | ------- | ----------------------------------------
$coupon | true     | string | null    | The coupon unique identifier.

##### Example

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

#### $entity->isSubscribed()

This method will help you to determine if the entity has any active subscription.

##### Example

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

#### $entity->hasActiveCard()

This method will help you to determine if the entity has any active credit card.

##### Example

```php
$user = User::find(1);

if ($user->hasActiveCard())
{
	//
}
```

#### $entity->syncWithStripe()

If you have the need to completely have your local data in sync with the Stripe data, you can use the `syncWithStripe()` method.

This will syncronize up the cards, charges, invoices and their invoice items, the pending invoice items and subscriptions that belongs to your entity.

##### Example

```php
$user = User::find(1);

$user->syncWithStripe();
```
