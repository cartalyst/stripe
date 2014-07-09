## Subscriptions

### Create a subscription

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
$subscription = Stripe::subscriptions()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'plan'     => 'monthly',
]);

echo $subscription['id'];
```

### Cancel a subscription

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

Cancel at the end of the period

```php
$subscription = Stripe::subscriptions()->cancel([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4ETjGeEPC5ai9J',
	'at_period_end' => true,
]);
```

### Update a subscription

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

### Retrieve all the subscriptions of a customer

Key            | Required | Type    | Default | Description
-------------- | -------- | ------- | ------- | --------------------------------
customer       | true     | string  | null    | ID of the customer that this subscription belongs to.
ending_before  | false    | string  | null    | A cursor to be used in pagination.
limit          | false    | integer | 10      | A limit on the number of objects to be returned.
starting_after | false    | string  | null    | A cursor to be used in pagination.

```php
$subscriptions = Stripe::subscriptions()->all([
	'id' => 'cus_4EBumIjyaKooft',
]);

foreach ($subscriptions['data'] as $subscription)
{
	var_dump($subscription['id']);
}
```

### Retrieve a subscription of a customer

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

### Delete a subscription discount

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
customer | true     | string | null    | The customer unique identifier that this subscription belongs to.
id       | true     | string | null    | The subscription unique identifier.

```php
$customer = Stripe::subscriptions()->deleteDiscount([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
])->findArray();
```
