### Invoices

#### Creating Invoices

Creating invoices on your billable entities is a breeze.

###### Create the invoices item and Create the Invoice

First we need to create an invoice item:

```php
$item = $user->invoice()->items()->create([
	'amount'      => 34.50,
	'currency'    => 'USD',
	'description' => 'Line 1 description',
]);
```

Now that we have our item created we can create our invoice:

```php
$invoice = $user->invoice()->create();
```

###### Create a new Invoice and pass in invoice line items

```php
$invoice = $user->invoice()->create([
	'items' => [
		[
			'amount'      => 34.50,
			'currency'    => 'USD',
			'description' => 'Line 1 description',
		],
		[
			'amount'      => 10.95,
			'currency'    => 'USD',
			'description' => 'Line 2 description',
		],
	],
]);
```

#### Pay an Invoice

```php
$user->invoice(10)->pay();
```

or

```php
$user->invoice()->pay('in_4TGCNPyz32qIUr');
```

#### Retrieve all the invoices

```php
$user = User::find(1);

$invoices = $user->invoices;
```

#### Retrieve an existing invoice

```php
$user = User::find(1);

$invoice = $user->invoices->find(10);

$items = $invoice->items;

echo $invoice['total'];
```

#### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->invoice()
	->syncWithStripe();
```

> **Note:** You can pass a invoice id `integer` or a `Cartalyst\Stripe\Billing\Models\IlluminateInvoice` object through the `invoice()` method.
