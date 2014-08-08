### Subscriptions

Subscriptions allow you to charge a customer's card on a recurring basis. A subscription ties a customer to a particular plan.

#### Create a subscription

Creates a new subscription on an existing customer.

Key                     | Required | Type            | Default | Description
----------------------- | -------- | --------------- | ------- | ---------------
customer                | true     | string          | null    | The customer unique identifier that this subscription belongs to.
plan                    | true     | string          | null    | The plan unique identifier.
coupon                  | false    | string          | null    | The coupon unique identifier.
trial_end               | false    | int             | null    | UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.
card                    | false    | string or array | null    | The card token or an array.
quantity                | false    | int             | 1       | The quantity you'd like to apply to the subscription you're creating.
application_fee_percent | false    | int             | null    | A positive decimal (with at most two decimal places) between 1 and 100.
metadata                | false    | array           | []      | A set of key/value pairs that you can attach to a subscription object.

```php
$subscription = Stripe::subscriptions()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'plan'     => 'monthly',
]);

echo $subscription['id'];
```

#### Cancel a subscription

Cancels a customer's subscription. If you set the `at_period_end` parameter to true, the subscription will remain active until the end of the period, at which point it will be canceled and not renewed. By default, the subscription is terminated immediately. In either case, the customer will not be charged again for the subscription. Note, however, that any pending invoice items that you've created will still be charged for at the end of the period unless manually deleted. If you've set the subscription to cancel at period end, any pending prorations will also be left in place and collected at the end of the period, but if the subscription is set to cancel immediately, pending prorations will be removed.

By default, all unpaid invoices for the customer will be closed upon subscription cancellation. We do this in order to prevent unexpected payment retries once the customer has canceled a subscription. However, you can reopen the invoices manually after subscription cancellation to have us proceed with automatic retries, or you could even re-attempt payment yourself on all unpaid invoices before allowing the customer to cancel the subscription at all.

Key           | Required | Type   | Default | Description
------------- | -------- | ------ | ------- | ----------------------------------
customer      | true     | string | null    | The customer unique identifier that this subscription belongs to.
id            | true     | string | null    | The subscription unique identifier.
at_period_end | false    | bool   | false   | A flag that if set to true will delay the cancellation of the subscription until the end of the current period.

```php
$subscription = Stripe::subscriptions()->cancel([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
]);
```

###### Cancel at the end of the period

```php
$subscription = Stripe::subscriptions()->cancel([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4ETjGeEPC5ai9J',
	'at_period_end' => true,
]);
```

#### Update a subscription

Updates an existing subscription on a customer to match the specified parameters. When changing plans or quantities, we will optionally prorate the price we charge next month to make up for any price changes.

Key                     | Required | Type            | Default | Description
----------------------- | -------- | --------------- | ------- | ---------------
customer                | true     | string          | null    | The customer unique identifier that this subscription belongs to.
id                      | true     | string          | null    | The subscription unique identifier.
plan                    | false    | string          | null    | The plan unique identifier.
coupon                  | false    | string          | null    | The coupon unique identifier.
prorate                 | false    | bool            | true    | Flag telling us whether to prorate switching plans during a billing cycle.
trial_end               | false    | int             | null    | UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.
card                    | false    | string or array | null    | The card token or an array.
quantity                | false    | int             | 1       | The quantity you'd like to apply to the subscription you're creating.
application_fee_percent | false    | int             | null    | A positive decimal (with at most two decimal places) between 1 and 100.
metadata                | false    | array           | []      | A set of key/value pairs that you can attach to a subscription object.

```php
$subscription = Stripe::subscriptions()->update([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4EUEBlsoU7kRHX',
	'plan'          => 'monthly',
	'at_period_end' => false,
]);
```

#### Retrieve all the subscriptions of a customer

You can see a list of the customer's active subscriptions. Note that the 10 most recent active subscriptions are always available by default on the customer object. If you need more than those 10, you can use the limit and `starting_after` parameters to page through additional subscriptions.

Key            | Required | Type    | Default | Description
-------------- | -------- | ------- | ------- | --------------------------------
customer       | true     | string  | null    | The customer unique identifier that this subscription belongs to.
ending_before  | false    | string  | null    | A cursor to be used in pagination.
limit          | false    | integer | 10      | A limit on the number of objects to be returned.
starting_after | false    | string  | null    | A cursor to be used in pagination.

```php
$subscriptions = Stripe::subscriptions()->all([
	'customer' => 'cus_4EBumIjyaKooft',
]);

foreach ($subscriptions['data'] as $subscription)
{
	var_dump($subscription['id']);
}
```

#### Retrieve a subscription of a customer

Retrieves the details of an existing customer subscription.

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
customer | true     | string | null    | The customer unique identifier that this subscription belongs to.
id       | true     | string | null    | The subscription unique identifier.

```
$subscription = Stripe::subscriptions()->find([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
]);

echo $subscription['id'];
```

###### Using the alias

```php
$charge = Stripe::subscription('cus_4EBumIjyaKooft', 'sub_4ETjGeEPC5ai9J');
```

#### Delete a subscription discount

Removes the currently applied discount on a subscription.

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
customer | true     | string | null    | The customer unique identifier that this subscription belongs to.
id       | true     | string | null    | The subscription unique identifier.

```php
$customer = Stripe::subscriptions()->deleteDiscount([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
])->toArray();
```
