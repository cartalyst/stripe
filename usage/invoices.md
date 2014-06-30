## Invoices

### List all the user invoices

```php
$user = User::find(1);

$invoices = $user->invoices;
```

### Retrieve an existing invoice

```php
$user = User::find(1);

$invoice = $user->invoices->find(10);

$items = $invoice->items;

echo $invoice['total'];
```



### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->invoice()
	->syncWithStripe();
```

> **Note:** You can pass a invoice id `integer` or a `Cartalyst\Stripe\Billing\Models\IlluminateInvoice` object through the `invoice()` method.
