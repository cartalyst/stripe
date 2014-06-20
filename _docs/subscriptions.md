## Subscriptions

### Create a subscription

```php
$subscription = Stripe::subscriptions()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'plan'     => 'monthly',
])->toArray();

echo $subscription['id'];
```

### Cancel a subscription

```php
$subscription = Stripe::subscriptions()->cancel([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4ETjGeEPC5ai9J',
	'at_period_end' => 'true', # needs to be a string, Guzzle converts booleans to integers at the moment
])->toArray();
```

Cancel at the end of the period

```php
$subscription = Stripe::subscriptions()->cancel([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4ETjGeEPC5ai9J',
	'at_period_end' => 'true', # needs to be a string, Guzzle converts booleans to integers at the moment
])->toArray();
```

### Update a subscription

```php
$subscription = Stripe::subscriptions()->update([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'sub_4EUEBlsoU7kRHX',
	'plan'          => 'monthly',
	'at_period_end' => 'false', # needs to be a string, Guzzle converts booleans to integers at the moment
])->toArray();
```

### Retrieve all subscriptions

```php
$subscriptions = Stripe::subscriptions()->all([
	'id' => 'cus_4EBumIjyaKooft',
])->toArray();

foreach ($subscriptions['data'] as $subscription)
{
	var_dump($subscription['id']);
}
```

### Retrieve a subscription

```
$subscription = Stripe::subscriptions()->find([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
])->toArray();

echo $subscription['id'];
```

### Delete a subscription discount

```php
$customer = Stripe::subscriptions()->deleteDiscount([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'sub_4ETjGeEPC5ai9J',
])->findArray();
```
