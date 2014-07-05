# Billable Entities

In this section we'll show how you can use the entity billing feature.

We'll use a User model for the following examples.

### Apply a coupon on the entity

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

### Update the entity Default Credit Card

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user->updateDefaultCard($token);
```

### Check if the entity has any active subscription

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

### Check if the entity has any active credit card

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
