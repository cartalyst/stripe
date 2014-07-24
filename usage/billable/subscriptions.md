### Subscriptions

#### List all the user subscriptions

```php
$user = User::find(1);

$subscriptions = $user->subscriptions;
```

#### Creating subscriptions

Subscribing an entity to a plan

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->setToken($token)
	->create();
```

Subscribing an entity to a plan and apply a coupon to this new subscription

```php
$token = Input::get('stripeToken');

$coupon = Input::get('coupon');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->withCoupon($coupon)
	->setToken($token)
	->create();
```

Create a trial subscription

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->subscription()
	->onPlan('monthly')
	->trialFor(Carbon::now()->addDays(14))
	->setToken($token)
	->create();
```

#### Cancelling subscriptions

Cancel a Subscription using its `id`

```php
$user = User::find(1);

$user
	->subscription(10)
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
	->subscription(10)
	->cancelAtEndOfPeriod();
```

#### Updating subscriptions

Apply a trial period on a subscription

```php
$user = User::find(1);

$user
	->subscription(10)
	->setTrialPeriod(Carbon::now()->addDays(14))
```

Removing the trial period from a subscription

```php
$user = User::find(1);

$user
	->subscription(10)
	->removeTrialPeriod()
```

Apply a coupon to an existing subscription

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user
	->subscription(10)
	->applyCoupon($coupon);
```

Remove a coupon from an existing subscription

```php
$user = User::find(1);

$user
	->subscription(10)
	->removeCoupon();
```

#### Resuming subscriptions

Resume a canceled subscription

```php
$user = User::find(1);

$user
	->subscription(10)
	->resume();
```

Resume a canceled subscription and remove its trial period

```php
$user = User::find(1);

$user
	->subscription(10)
	->skipTrial()
	->resume();
```

Resume a canceled subscription and change its trial period end date

```php
$user = User::find(1);

$user
	->subscription(10)
	->trialFor(Carbon::now()->addDays(14))
	->resume()
```

#### Checking a Subscription Status

First, we need to grab the subscription:

```php
$user = User::find(1);

$subscription = $user->subscriptions->find(10);
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

#### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->subscription()
	->syncWithStripe();
```

> **Note:** You can pass a subscription id `integer` or a `Cartalyst\Stripe\Billing\Models\IlluminateSubscription` object through the `subscription()` method.
