## Invoices

### Create a new invoice

```php
$invoice = Stripe::invoices()->create([
	'customer' => 'cus_4EgOG1jXMEt7Ou',
])->toArray();
```

### Update an invoice

```php
$invoice = Stripe::invoices()->update([
	'id'     => 'in_4EgP02zb8qxsLq',
	'closed' => 'true',
])->toArray();
```

### Pay an existing invoice

```php
$invoice = Stripe::invoices()->pay([
	'id' => 'in_4EgP02zb8qxsLq',
])->toArray();
```

### Retrieve all the existing invoices

```php
$invoices = Stripe::invoices()->all()->toArray();

foreach ($invoices['data'] as $invoice)
{
	var_dump($invoice['id']);
}
```

### Retrieve an existing invoice

```php
$invoice = Stripe::invoices()->find([
	'id' => 'in_4EgP02zb8qxsLq',
])->toArray();

echo $invoice['paid'];
```

### Retrieve an existing invoice line items

```php
$lines = Stripe::invoices()->invoiceLineItems([
	'id' => 'in_4EgP02zb8qxsLq',
])->toArray();

foreach ($lines['data'] as $line)
{
	var_dump($line['id']);
}
```
