## Customers

### Create a new customer

```php
$customer = Stripe::customers()->create([
	'email' => 'testing@example.com',
])->toArray();

echo $customer['id'];
```

### Delete a customer

```php
$customer = Stripe::customers()->delete([
	'id' => 'cus_4EBxvk6aBPexFO',
])->toArray();
```

### Update a customer

```php
$customer = Stripe::customers()->update([
	'id'    => 'cus_4EBumIjyaKooft',
	'email' => 'testing@example.com',
])->toArray();
```

### Retrieve all customers

```php
$customers = Stripe::customers()->all()->toArray();

foreach ($customers['id'] as $customer)
{
	var_dump($customer['id']);
}
```

### Retrieve a customer

```php
$customer = Stripe::customers()->find([
	'id' => 'cus_4EBumIjyaKooft',
])->toArray();
```

### Delete a customer discount

```php
$customer = Stripe::customers()->deleteDiscount([
	'id' => 'cus_4EBumIjyaKooft',
])->findArray();
```
