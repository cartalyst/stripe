## Refunds

### Retrieve all refunds of a charge

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
charge         | false    | string | null    | The charge unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$refunds = Stripe::refunds()->all([
	'charge' => 'ch_4ECWMVQp5SJKEx',
]);

foreach ($refunds['data'] as $refund)
{
	var_dump($refund['id']);
}
```

### Retrieve an existing refund

Key    | Required | Type   | Default | Description
------ | -------- | ------ | ------- | --------------------------------------------
charge | false    | string | null    | The charge unique identifier.
id     | true     | string | null    | The refund unique identifier.

```php
$refund = Stripe::refunds()->find([
	'charge' => 'ch_4ECWMVQp5SJKEx',
	'id'     => 'txn_4IgdBGArAOeiQw',
]);
```

### Update an existing refund

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | --------------------------------------------
charge   | false    | string | null    | The charge unique identifier.
id       | true     | string | null    | The refund unique identifier.
metadata | false    | array  | []      | A set of key/value pairs that you can attach to a refund object.

```php
$refund = Stripe::refunds()->update([
	'charge'   => 'ch_4ECWMVQp5SJKEx',
	'id'       => 'txn_4IgdBGArAOeiQw',
	'metadata' => [
		'reason'      => 'Customer requested for the refund.',
		'refunded_by' => 'Bruno G.',
	],
]);
```
