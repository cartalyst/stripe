## Invoice Items

### Create a new invoice item

```php
$item = Stripe::invoiceItems()->create([
	'customer' => 'cus_4EgOG1jXMEt7Ou',
	'currency' => 'USD',
	'amount'   => 5000,
]);

echo $item['id'];
```

### Update an invoice item

```php
$response = Stripe::invoiceItems()->update([
	'id'          => 'ii_4Egr3tUtHjVEnm',
	'description' => 'Candy',
	'metadata'    => [
		'foo' => 'Bar',
	],
]);
```

### Delete an invoice item

```php
$item = Stripe::invoiceItems()->delete([
	'id' => 'ii_4Egr3tUtHjVEnm',
]);

echo $item['id'];
```

### Retrieve all invoice items

```php
$items = Stripe::invoiceItems()->find();

foreach ($items['data'] as $item)
{
	var_dump($item['id']);
}
```

### Retrieve an invoice item

```php
$item = Stripe::invoiceItems()->find([
	'id' => 'ii_4Egr3tUtHjVEnm',
]);

echo $item['id'];
```
