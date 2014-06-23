## Application Fees

### Refund an application fee

```php
$fee = Stripe::fees()->refund([
	'id' => 'fee_4EUveQeJwxqxD4',
])->toArray();
```

### Retrieve all the application fees

```php
$fees = Stripe::fees()->all()->toArray();

foreach ($fees['data'] as $fee)
{
	var_dump($fee['id']);
}
```

### Retrieve an existing fee

```php
$fee = Stripe::fees()->find([
	'id' => 'fee_4EUveQeJwxqxD4',
])->toArray();

echo $fee['id'];
```
