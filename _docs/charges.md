## Charges

### Create a new charge

```php
$response = Stripe::charges()->update([
	'customer' => 'cus_4EBumIjyaKooft',
	'currency' => 'USD',
	'amount'   => 5049,
]);

$charge = $response->toArray();

echo $charge['id']
```

### Update a charge

```php
$response = Stripe::charges()->update([
	'id'          => 'ch_4ECWMVQp5SJKEx',
	'description' => 'Paymento to foo bar',
]);
```

### Capture a charge

...

### Refund a charge

```php
$response = Stripe::charges()->refund([
	'id' => 'ch_4ECWMVQp5SJKEx',
]);
```

### Retrieve all charges

```php
$response = Stripe::charges()->all();
```

Retrieve all charges for a specific customer

```php
$response = Stripe::charges()->all([
	'customer' => 'cus_4EBumIjyaKooft',
]);
```

### Retrieve an existing charge

```php
$response = Stripe::charges()->find([
	'id' => 'ch_4ECWMVQp5SJKEx',
]);
```
