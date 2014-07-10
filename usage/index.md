# Billable Entities

In this section we'll show how you can use the entity billing feature.

> **Note:** A User model will be used for the following examples.

### Determine if the entity is ready to be billed

If you require to determine if the entity is ready to be billed, you can use the `isBillable()` method.

```php
$user = User::find(1);

if ( ! $user->isBillable())
{
	echo "User is not ready to be billed!";
}
```

### Apply a coupon on the entity

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

### Check if the entity has any active subscription

Determine if the entity has any active subscription.

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

### Check if the entity has any active credit card

Determine if the entity has any active credit card.

```php
$user = User::find(1);

if ($user->hasActiveCard())
{
	//
}
```

### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

This will sync up the cards, charges, invoices + invoice items and subscriptions.

```php
$user = User::find(1);

$user->syncWithStripe();
```
