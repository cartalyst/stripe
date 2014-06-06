# User

## Apply a coupon to the user

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

## Update the user Default Credit Card

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user->updateDefaultCard($token);
```

## Check if the user has any active subscription

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

## Check if the user has any active credit card

```php
$user = User::find(1);

if ($user->hasActiveCard())
{
	//
}
```


# Subscriptions

## List all the user subscriptions

```php
$user = User::find(1);

$subscriptions = $user->subscriptions;
```

## Creating subscriptions

Subscribing a user to a plan

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->create($token);
```

Subscribing a user to a plan and apply a coupon to this new subscription

```php
$token = Input::get('stripeToken');

$coupon = Input::get('coupon');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->withCoupon($coupon)
	->create($token);
```

Create a trial subscription

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->trialFor(Carbon::now()->addDays(14))
	->create($token);
```

## Cancelling subscriptions

Cancel a Subscription using its `id`

```php
$user = User::find(1);

$user
	->subscription(3)
	->cancel();
```

Cancelling a subscription by passing a `Cartalyst\Stripe\Subscription\IlluminateSubscription` object.

```php
$user = User::find(1);

$subscription = $user->subscriptions()->where('stripe_id', 'sub_48w0VyQzcNWCe3')->first();

$user
	->subscription($subscription)
	->cancel();
```

Cancel a subscription at the End of the Period

```php
$user = User::find(1);

$user
	->subscription(3)
	->cancelAtEndOfPeriod();
```

## Updating subscriptions

Apply a trial period on a subscription

```php
$user = User::find(1);

$user
	->subscription(3)
	->setTrialPeriod(Carbon::now()->addDays(14))
```

Removing the trial period from a subscription

```php
$user = User::find(1);

$user
	->subscription(3)
	->removeTrialPeriod()
```

Apply a coupon to an existing subscription

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user
	->subscription(3)
	->applyCoupon($coupon);
```

Remove a coupon from an existing subscription

```php
$user = User::find(1);

$user
	->subscription(3)
	->removeCoupon();
```

## Resuming subscriptions

Resume a canceled subscription

```php
$user = User::find(1);

$user
	->subscription(3)
	->resume();
```

Resume a canceled subscription and remove its trial period

```php
$user = User::find(1);

$user
	->subscription(3)
	->skipTrial()
	->resume();
```

Resume a canceled subscription and change its trial period end date

```php
$user = User::find(1);

$user
	->subscription(3)
	->trialFor(Carbon::now()->addDays(14))
	->resume()
```

## Checking a Subscription Status

First, we need to grab the subscription:

```php
$user = User::find(1);

$subscription = $user->subscriptions->find(3);
```

To determine if the subscription is on the trial period, you may use the `onTrialPeriod()` method:

```php
if ($subscription->onTrialPeriod())
{
	//
}
```

To determine if the subscription is marked as canceled, you may use the `canceled` method:

```php
if ($subscription->canceled())
{
	//
}
```

To determine if the subscription has expired, you may use the `expired` method:

```php
if ($subscription->expired())
{
	//
}
```

You may also determine if a subscription, is still on their "grace period" until the subscription fully expires. For example, if a user cancels a subscription on March 5th that was scheduled to end on March 10th, the user is on their "grace period" until March 10th.

```php
if ($subscription->onGracePeriod())
{
	//
}
```

> **Note:** You can pass a subscription id `integer` or a `Cartalyst\Stripe\Subscription\IlluminateSubscription` object through the `subscription()` method.


# Cards

## List all the available Credit Cards

```php
$user = User::find(1);

$cards = $user->cards;
```

## Creating credit cards

Create a new Credit Card

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->card()
	->create($token);
```

If you want to make this new credit card the default credit card, you can use the `->makeDefault()` method:

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->card()
	->makeDefault()
	->create($token);
```

## Updating credit cards

Update a Credit Card

```php
$user = User::find(1);

$attributes = [
	'name' => 'John Doe',
];

$user
	->card(3)
	->update($attributes);
```

Make an existing credit card the default credit card.

```php
$user = User::find(1);

$user
	->card(3)
	->setDefault();
```

## Delete a Credit Card

```php
$user = User::find(1);

$user
	->card(3)
	->delete();
```

> **Note:** You can pass a card id `integer` or a `Cartalyst\Stripe\Card\IlluminateCard` object through the `card()` method.


# Charges

## List all the user charges

```php
$user = User::find(1);

$charges = $user->charges;
```

## Creating charges

```php
$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Creating a charge to be captured later.

```php
$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->disableCapture()
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Creating a charge with a new credit card.

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->setToken($token)
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Capturing a charge.

```php
$user = User::find(1);

$user
	->charge(3)
	->capture();
```

## Refund charges

Do a full refund

```php
$user = User::find(1);

$user
	->charge(3)
	->refund();
```

Do a partial refund

```php
$user = User::find(1);

$amount = 50.00;

$user
	->charge(3)
	->refund($amount);
```

> **Note:** You can pass a charge id `integer` or a `Cartalyst\Stripe\Charge\IlluminateCharge` object through the `charge()` method.
