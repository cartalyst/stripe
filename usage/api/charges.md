## Charges

### Create a new charge

```php
$charge = Stripe::charges()->update([
	'customer' => 'cus_4EBumIjyaKooft',
	'currency' => 'USD',
	'amount'   => 5049,
])->toArray();

echo $charge['id'];
```

### Update a charge

```php
$charge = Stripe::charges()->update([
	'id'          => 'ch_4ECWMVQp5SJKEx',
	'description' => 'Payment to foo bar',
])->toArray();
```

### Capture a charge

```php
$charge = Stripe::charges()->capture([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```

### Refund a charge

```php
$charge = Stripe::charges()->refund([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```

### Retrieve all charges

```php
$charges = Stripe::charges()->all()->toArray();

foreach ($charges['data'] as $charge)
{
	var_dump($charge['id']);
}
```

Retrieve all charges for a specific customer

```php
$charges = Stripe::charges()->all([
	'customer' => 'cus_4EBumIjyaKooft',
])->toArray();

foreach ($charges['data'] as $charge)
{
	var_dump($charge['id']);
}
```

### Retrieve an existing charge

```php
$charge = Stripe::charges()->find([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```
