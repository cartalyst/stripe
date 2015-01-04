### Invoices

Invoices are statements of what a customer owes for a particular billing period, including subscriptions, invoice items, and any automatic proration adjustments if necessary.

#### Create a new invoice

If you need to invoice your customer outside the regular billing cycle, you can create an invoice that pulls in all pending invoice items, including prorations. The customer's billing cycle and regular subscription won't be affected.

Once you create the invoice, it'll be picked up and paid automatically, though you can choose to [pay it right away](#pay-an-existing-invoice).

##### Arguments

Key                   | Required | Type   | Default | Description
--------------------- | -------- | ------ | ------- | --------------------------
customer              | true     | string | null    | The customer unique identifier.
application_fee       | false    | int    | null    | An application fee to add on to this invoice.
description           | false    | string | null    | An arbitrary string which you can attach to a invoice object.
metadata              | false    | array  | []      | A set of key/value pairs that you can attach to a invoice object.
statement_description | false    | string | null    | An arbitrary string to be displayed alongside your company name on your customer's credit card statement.
subscription          | false    | string | null    | The subscription unique identifier to invoice.

```php
$invoice = Stripe::invoices()->create([
	'customer' => 'cus_4EBumIjyaKooft',
]);
```

#### Update an invoice

Until an invoice is paid, it is marked as open (closed=false). If you'd like to stop Stripe from automatically attempting payment on an invoice or would simply like to close the invoice out as no longer owed by the customer, you can update the closed parameter.

##### Arguments

Key                   | Required | Type   | Default | Description
--------------------- | -------- | ------ | ------- | --------------------------
id                    | true     | string | null    | The invoice unique identifier.
application_fee       | false    | int    | null    | An application fee to add on to this invoice.
closed                | false    | bool   | false   | Boolean representing whether an invoice is closed or not.
description           | false    | string | null    | An arbitrary string which you can attach to a invoice object.
forgiven              | false    | bool   | false   | Boolean representing whether an invoice is forgiven or not.
metadata              | false    | array  | []      | A set of key/value pairs that you can attach to a invoice object.
statement_description | false    | string | null    | An arbitrary string to be displayed alongside your company name on your customer's credit card statement.
subscription          | false    | string | null    | The subscription unique identifier to invoice.

```php
$invoice = Stripe::invoices()->update([
	'id'     => 'in_4EgP02zb8qxsLq',
	'closed' => true,
]);
```

#### Pay an existing invoice

Stripe automatically creates and then attempts to pay invoices for customers on subscriptions. We'll also retry unpaid invoices according to your [retry settings](https://dashboard.stripe.com/account/recurring). However, if you'd like to attempt to collect payment on an invoice out of the normal retry schedule or for some other reason, you can do so.

##### Arguments

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The invoice unique identifier.

```php
$invoice = Stripe::invoices()->pay([
	'id' => 'in_4EgP02zb8qxsLq',
]);
```

#### Retrieve all the existing invoices

You can list all invoices, or list the invoices for a specific customer. The invoices are returned sorted by creation date, with the most recently created invoices appearing first.

##### Arguments

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
customer       | false    | string | null    | The customer unique identifier.
date           | false    | string | null    | A filter on the list based on the object date field.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$invoices = Stripe::invoices()->all();

foreach ($invoices['data'] as $invoice)
{
	var_dump($invoice['id']);
}
```

#### Retrieve an existing invoice

Retrieves the invoice with the given ID.

##### Arguments

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The invoice unique identifier.

```php
$invoice = Stripe::invoices()->find([
	'id' => 'in_4EgP02zb8qxsLq',
]);

echo $invoice['paid'];
```

###### Using the alias

```php
$charge = Stripe::invoice('in_4EgP02zb8qxsLq');
```

#### Retrieve an existing invoice line items

When retrieving an invoice, you'll get a lines property containing the total count of line items and the first handful of those items. There is also a URL where you can retrieve the full (paginated) list of line items.

##### Arguments

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
id             | true     | string | null    | The invoice unique identifier.
customer       | false    | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.
subscription   | false    | string | null    | The subscription unique identifier.

```php
$lines = Stripe::invoices()->invoiceLineItems([
	'id' => 'in_4EgP02zb8qxsLq',
]);

foreach ($lines['data'] as $line)
{
	var_dump($line['id']);
}
```

#### Retrieve the upcoming invoice

At any time, you can preview the upcoming invoice for a customer. This will show you all the charges that are pending, including subscription renewal charges, invoice item charges, etc. It will also show you any discount that is applicable to the customer.

Note that when you are viewing an upcoming invoice, you are simply viewing a preview -- the invoice has not yet been created. As such, the upcoming invoice will not show up in invoice listing calls, and you cannot use the API to pay or edit the invoice. If you want to change the amount that your customer will be billed, you can add, remove, or update pending invoice items, or update the customer's discount.

##### Arguments

Key          | Required | Type   | Default | Description
------------ | -------- | ------ | ------- | -----------------------------------
customer     | true     | string | null    | The customer unique identifier.
subscription | false    | string | null    | The subscription unique identifier.

```php
$invoice = Stripe::invoices()->upcomingInvoice([
	'customer' => 'cus_4EBumIjyaKooft',
]);

foreach ($invoice['lines']['data'] as $item)
{
	var_dump($item['id']);
}
```
