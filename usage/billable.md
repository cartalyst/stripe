## Billable Entities

In this section we'll show how you can use the entity billing feature.

> **Note:** A User model will be used for the following examples.

###### Determine if the entity is ready to be billed

If you need to determine if the entity is ready to be billed, you can use the `isBillable()` method.

```php
$user = User::find(1);

if ( ! $user->isBillable())
{
	echo "User is not ready to be billed!";
}
```

###### Apply a coupon on the entity

```php
$coupon = Input::get('coupon');

$user = User::find(1);

$user->applyCoupon($coupon);
```

###### Check if the entity has any active subscription

Determine if the entity has any active subscription.

```php
$user = User::find(1);

if ($user->isSubscribed())
{
	//
}
```

###### Check if the entity has any active credit card

Determine if the entity has any active credit card.

```php
$user = User::find(1);

if ($user->hasActiveCard())
{
	//
}
```

###### Syncronize data from Stripe

Often you might have the need to syncronize the data from Stripe with your database, we have an easy way to achieve this.

This will syncronize up the cards, charges, invoices and their invoice items, the pending invoice items and subscriptions.

```php
$user = User::find(1);

$user->syncWithStripe();
```

###### Attach a Stripe Customer to an Entity

Attaching a Stripe Customer to an entity is not a very hard job but we've made it even easier.

```php
$customer = Stripe::customer('cus_4EBumIjyaKooft')->toArray();

User::attachStripeCustomer($customer, function($data)
{
	return User::where('email', $data['email'])->first();
});
```

The way this method works is very simple, you need to call the `attachStripeCustomer()` method pass as the first argument the `$customer` data and as the second argument a `Closure`, the `Closure` only accepts one argument and it's the `$customer` that you've passed as it will be useful when doing a search on your database.

For the `Closure` response, make sure it returns a valid `entity` model like the example above.

By default, the third parameter allows you to syncronize the Stripe Customer data for your entity, to disable this feature, just pass a boolean of `false`.

###### Attach all the Stripe Customers to their entities

Works almost exactly like the `attachStripeCustomer()` method, but it requires no `$customer` upfront as this method will fetch all the Stripe Customers and loop through them calling the `attachStripeCustomer()` method internally.

```php
User::attachStripeCustomers(function($data)
{
	return User::where('email', $data['email'])->first();
});
```
