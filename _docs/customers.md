## Customers

### Create a new customer

```php
$response = Stripe::customers()->create([
	'email' => 'testing@example.com',
]);

$customer = $response->toArray();

echo $customer['id'];
```

### Delete a customer

```php
$response = Stripe::customers()->delete([
	'id' => 'cus_4EBxvk6aBPexFO',
]);
```

### Update a customer

```php
$response = Stripe::customers()->update([
	'id' => 'cus_4EBumIjyaKooft',
	'email' => 'testing@example.com',
]);

```

### Retrieve all customers

$response = Stripe::customers()->all();

### Retrieve a customer

$response = Stripe::customers()->find([
	'id' => 'cus_4EBumIjyaKooft',
]);
