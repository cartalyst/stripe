## Invoices

### Create a new invoice

```php
$invoice = Stripe::invoices()->create([
	'customer' => 'cus_4EgOG1jXMEt7Ou',
]);
```

### Update an invoice

```php
$invoice = Stripe::invoices()->update([
	'id'     => 'in_4EgP02zb8qxsLq',
	'closed' => true,
]);
```

### Pay an existing invoice

```php
$invoice = Stripe::invoices()->pay([
	'id' => 'in_4EgP02zb8qxsLq',
]);
```

### Retrieve all the existing invoices

```php
$invoices = Stripe::invoices()->all();

foreach ($invoices['data'] as $invoice)
{
	var_dump($invoice['id']);
}
```

### Retrieve an existing invoice

```php
$invoice = Stripe::invoices()->find([
	'id' => 'in_4EgP02zb8qxsLq',
]);

echo $invoice['paid'];
```

### Retrieve an existing invoice line items

```php
$lines = Stripe::invoices()->invoiceLineItems([
	'id' => 'in_4EgP02zb8qxsLq',
]);

foreach ($lines['data'] as $line)
{
	var_dump($line['id']);
}
```

### Retrieve the upcoming invoice

```php
$invoice = Stripe::invoices()->upcomingInvoice([
	'customer' => 'cus_4EgOG1jXMEt7Ou',
]);

foreach ($invoice['lines']['data'] as $item)
{
	var_dump($item['id']);
}
```
