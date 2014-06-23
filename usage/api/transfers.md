## Transfers

### Create a new transfer

Key                   | Required | Type    | Description
--------------------- | -------- | ------- | -----------------------------------
amount                | true     | integer | A positive integer in the smallest currency unit.
currency              | true     | string  | 3-letter ISO code for currency.
recipient             | true     | string  | The ID of an existing, verified recipient.
description           | false    | string  | An arbitrary string which you can attach to a transfer object.
statement_description | false    | string  | An arbitrary string which will be displayed on the recipient\'s bank statement.
metadata              | false    | array   | A set of key/value pairs that you can attach to a transfer object

```php
$transfer = Stripe::transfers()->create([
	'amount'    => 10,
	'currency'  => 'USD',
	'recipient' => 'rp_4EYxxX0LQWYDMs',
])->toArray();

echo $transfer['id'];
```

### Update a transfer

Key         | Required | Type    | Description
----------- | -------- | ------- | ---------------------------------------------
id          | true     | string  | The transfer unique identifier.
description | false    | string  | An arbitrary string which you can attach to a transfer object.
metadata    | false    | array   | A set of key/value pairs that you can attach to a transfer object

```php
$transfer = Stripe::transfers()->update([
	'id'          => 'tr_4EZer9REaUzJ76',
	'description' => 'Transfer to John Doe',
])->toArray();

echo $transfer['id'];
```

### Cancel a transfer

Key | Required | Type    | Description
--- | -------- | ------- | -----------------------------------------------------
id  | true     | string  | The transfer unique identifier.

```php
$transfer = Stripe::transfers()->cancel([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();
```

### Retrieve all the existing transfers

Key            | Required | Type    | Description
-------------- | -------- | ------- | ------------------------------------------
created        | false    | string  | A filter on the list based on the object created field.
date           | false    | string  | A filter on the list based on the object date field.
ending_before  | false    | string  | A cursor to be used in pagination.
limit          | false    | integer | A limit on the number of objects to be returned.
recipient      | false    | string  | Only return transfers for the recipient specified by this recipient ID.
starting_after | false    | string  | A cursor to be used in pagination.
status         | false    | string  | Only return transfers that have the given status: "pending", "paid", or "failed".

```php
$transfers = Stripe::transfers()->all()->toArray();

foreach ($transfers['data'] as $transfer)
{
	var_dump($transfer['id']);
}
```

### Retrieve an existing transfer

Key | Required | Type    | Description
--- | -------- | ------- | -----------------------------------------------------
id  | true     | string  | The transfer unique identifier.

```php
$transfers = Stripe::transfers()->find([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();

echo $transfer['id'];
```
