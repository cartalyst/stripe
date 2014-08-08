### Invoice Items

Sometimes you want to add a charge or credit to a customer but only actually charge the customer's card at the end of a regular billing cycle. This is useful for combining several charges to minimize per-transaction fees or having Stripe tabulate your usage-based billing totals.

#### Create a new invoice item

Adds an arbitrary charge or credit to the customer's upcoming invoice.

Key          | Required | Type   | Default | Description
------------ | -------- | ------ | ------- | -----------------------------------
customer     | true     | string | null    | The customer unique identifier.
amount       | true     | number | null    | A positive amount for the transaction.
currency     | true     | string | null    | 3-letter ISO code for currency.
invoice      | false    | string | null    | The invoice unique identifier.
subscription | false    | string | null    | The subscription unique identifier to invoice.
description  | false    | string | null    | An arbitrary string which you can attach to a invoice item object.
metadata     | false    | array  | []      | A set of key/value pairs that you can attach to a invoice item object.

```php
$item = Stripe::invoiceItems()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'amount'   => 50.00,
	'currency' => 'USD',
]);

echo $item['id'];
```

#### Update an invoice item

Updates the amount or description of an invoice item on an upcoming invoice. Updating an invoice item is only possible before the invoice it's attached to is closed.

Key         | Required | Type   | Default | Description
----------- | -------- | ------ | ------- | ------------------------------------
id          | true     | string | null    | The invoice item unique identifier.
amount      | false    | number | null    | A positive amount for the transaction.
description | false    | string | null    | An arbitrary string which you can attach to a invoice item object.
metadata    | false    | array  | []      | A set of key/value pairs that you can attach to a invoice item object.

```php
$item = Stripe::invoiceItems()->update([
	'id'          => 'ii_4Egr3tUtHjVEnm',
	'description' => 'Candy',
	'metadata'    => [
		'foo' => 'Bar',
	],
]);
```

#### Delete an invoice item

Removes an invoice item from the upcoming invoice. Removing an invoice item is only possible before the invoice it's attached to is closed.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The invoice item unique identifier.

```php
Stripe::invoiceItems()->destroy([
	'id' => 'ii_4Egr3tUtHjVEnm',
]);
```

#### Retrieve all invoice items

Returns a list of your invoice items. Invoice Items are returned sorted by creation date, with the most recently created invoice items appearing first.

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
customer       | false    | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$items = Stripe::invoiceItems()->find();

foreach ($items['data'] as $item)
{
	var_dump($item['id']);
}
```

#### Retrieve an invoice item

Retrieves the invoice item with the given ID.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The invoice item unique identifier.

```php
$item = Stripe::invoiceItems()->find([
	'id' => 'ii_4Egr3tUtHjVEnm',
]);

echo $item['amount'];
```

###### Using the alias

```php
$charge = Stripe::invoiceItem('ii_4Egr3tUtHjVEnm');
```
