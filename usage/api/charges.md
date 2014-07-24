### Charges

To charge a credit or a debit card, you create a new charge object. You can retrieve and refund individual charges as well as list all charges. Charges are identified by a unique ID.

#### Create a new charge

To charge a credit card, you need to create a new charge object. If your API key is in test mode, the supplied card won't actually be charged, though everything else will occur as if in live mode. (Stripe will assume that the charge would have completed successfully).

Key                   | Required | Type            | Default | Description
--------------------- | -------- | --------------- | ------- | -----------------
amount                | true     | number          | null    | A positive amount for the transaction.
currency              | true     | string          | null    | 3-letter ISO code for currency.
customer              | false    | string          | null    | The customer unique identifier.
card                  | false    | string or array | null    | The card unique identifier.
description           | false    | string          | null    | An arbitrary string which you can attach to a charge object.
metadata              | false    | array           | []      | A set of key/value pairs that you can attach to a charge object.
capture               | false    | bool            | null    | Whether or not to immediately capture the charge.
statement_description | false    | string          | null    | An arbitrary string to be displayed alongside your company name on your customer's credit card statement.
receipt_email         | false    | string          | null    | The email address to send this charge’s receipt to.
application_fee       | false    | int             | null    | An application fee to add on to this charge.

```php
$charge = Stripe::charges()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'currency' => 'USD',
	'amount'   => 50.49,
]);

echo $charge['id'];
```

#### Update a charge

Updates the specified charge by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

Key         | Required | Type   | Default | Description
----------- | -------- | ------ | ------- | ------------------------------------
id          | true     | string | null    | The charge unique identifier.
description | false    | string | null    | An arbitrary string which you can attach to a charge object.
metadata    | false    | array  | []      | A set of key/value pairs that you can attach to a charge object.

```php
$charge = Stripe::charges()->update([
	'id'          => 'ch_4ECWMVQp5SJKEx',
	'description' => 'Payment to foo bar',
]);
```

#### Capture a charge

Capture the payment of an existing, uncaptured, charge. This is the second half of the two-step payment flow, where first you [created a charge](#create-a-new-charge) with the capture option set to false.

Uncaptured payments expire exactly seven days after they are created. If they are not captured by that point in time, they will be marked as refunded and will no longer be capturable.

Key                    | Required | Type   | Default | Description
---------------------- | -------- | ------ | ------- | -------------------------
id                     | true     | string | null    | The charge unique identifier.
amount                 | false    | number | null    | A positive amount for the transaction.
refund_application_fee | false    | bool   | null    | Boolean indicating whether the application fee should be refunded when refunding this charge.
metadata               | false    | array  | []      | A set of key/value pairs that you can attach to a charge object.

```php
$charge = Stripe::charges()->capture([
	'id' => 'ch_4ECWMVQp5SJKEx',
]);
```

#### Refund a charge

Key             | Required | Type   | Default | Description
--------------- | -------- | ------ | ------- | --------------------------------
id              | true     | string | null    | The charge unique identifier.
amount          | false    | number | null    | A positive amount for the transaction.
application_fee | false    | int    | null    | An application fee to add on to this charge.
receipt_email   | false    | string | null    | The email address to send this charge’s receipt to.

```php
$charge = Stripe::charges()->refund([
	'id' => 'ch_4ECWMVQp5SJKEx',
]);
```

#### Retrieve all charges

Returns a list of charges you've previously created. The charges are returned in sorted order, with the most recent charges appearing first.

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
customer       | false    | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$charges = Stripe::charges()->all();

foreach ($charges['data'] as $charge)
{
	var_dump($charge['id']);
}
```

#### Retrieve an existing charge

Retrieves the details of a charge that has been previously created. Supply the unique charge ID that was returned from a previous request, and Stripe will return the corresponding charge information. The same information is returned when creating or refunding the charge.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The charge unique identifier.

```php
$charge = Stripe::charges()->find([
	'id' => 'ch_4ECWMVQp5SJKEx',
]);
```
