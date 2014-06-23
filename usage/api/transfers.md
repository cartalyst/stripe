## Transfers

### Create a new transfer

Key                   | Required | Type   | Default | Description
--------------------- | -------- | ------ | ------- | --------------------------
amount                | true     | int    | null    | A positive integer in the smallest currency unit.
currency              | true     | string | null    | 3-letter ISO code for currency.
recipient             | true     | string | null    | The ID of an existing, verified recipient.
description           | false    | string | null    | An arbitrary string which you can attach to a transfer object.
statement_description | false    | string | null    | An arbitrary string which will be displayed on the recipient's bank statement.
metadata              | false    | array  | []      | A set of key/value pairs that you can attach to a transfer object

```php
$transfer = Stripe::transfers()->create([
	'amount'    => 10,
	'currency'  => 'USD',
	'recipient' => 'rp_4EYxxX0LQWYDMs',
])->toArray();

echo $transfer['id'];
```

### Update a transfer

Key         | Required | Type    | Default | Description
----------- | -------- | ------- | ------- | -----------------------------------
id          | true     | string  | null    | The transfer unique identifier.
description | false    | string  | null    | An arbitrary string which you can attach to a transfer object.
metadata    | false    | array   | []      | A set of key/value pairs that you can attach to a transfer object

```php
$transfer = Stripe::transfers()->update([
	'id'          => 'tr_4EZer9REaUzJ76',
	'description' => 'Transfer to John Doe',
])->toArray();

echo $transfer['id'];
```

### Cancel a transfer

Key | Required | Type    | Default | Description
--- | -------- | ------- | ------- | -------------------------------------------
id  | true     | string  | null    | The transfer unique identifier.

```php
$transfer = Stripe::transfers()->cancel([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();
```

### Retrieve all the existing transfers

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
date           | false    | string | null    | A filter on the list based on the object date field.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
recipient      | false    | string | null    | Only return transfers for the recipient specified by this recipient ID.
starting_after | false    | string | null    | A cursor to be used in pagination.
status         | false    | string | null    | Only return transfers that have the given status: "pending", "paid", or "failed".

```php
$transfers = Stripe::transfers()->all()->toArray();

foreach ($transfers['data'] as $transfer)
{
	var_dump($transfer['id']);
}
```

### Retrieve an existing transfer

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The transfer unique identifier.

```php
$transfers = Stripe::transfers()->find([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();

echo $transfer['id'];
```
