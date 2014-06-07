# Usage

In this section we'll show how you can use the Stripe package with your model.

We'll use a User model for the following examples.

### Apply a coupon to the user

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

### Update the user Default Credit Card

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user->updateDefaultCard($token);
```

### Check if the user has any active subscription

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

### Check if the user has any active credit card

```php
$user = User::find(1);

if ($user->hasActiveCard())
{
	//
}
```

### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

This will sync up the cards, charges and subscriptions.

```php
$user = User::find(1);

$user
	->syncWithStripe();
```
