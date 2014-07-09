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

### Set invoice metadata

Sometimes you might need to store additional information that is relevant to an invoice, like an order id or even the billing information of a customer.

With the Stripe package storing this kind of information is a breeze, here's how you do it:

First you need to grab the invoice you want to attach metadata:

```php
$user = User::find(1);

$invoice = $user->invoice->find(10);
```

Now you can attach metadata to this invoice

```php
$invoice->metadata()->create([
	'name'    => 'John Doe',
	'address' => 'John Doe Industries',
]);
```

> **Note:** The metadata table columns are configurable through the migration, but keep in mind that you might require to extend the invoice metadata model to include your own column names on the `$fillable` property.


### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->invoice()
	->syncWithStripe();
```

> **Note:** You can pass a invoice id `integer` or a `Cartalyst\Stripe\Billing\Models\IlluminateInvoice` object through the `invoice()` method.
