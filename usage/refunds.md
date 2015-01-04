### Refunds

Refund objects allow you to refund a charge that has previously been created but not yet refunded. Funds will be refunded to the credit or debit card that was originally charged. The fees you were originally charged are also refunded.

#### Refund a charge

Creating a new refund will refund a charge that has previously been created but not yet refunded. Funds will be refunded to the credit or debit card that was originally charged. The fees you were originally charged are also refunded.

##### Arguments

Key                    | Required | Type   | Default | Description
---------------------- | -------- | ------ | ------- | -------------------------
charge                 | true     | string | null    | The charge unique identifier.
amount                 | false    | number | null    | A positive amount for the transaction.
refund_application_fee | false    | int    | null    | Boolean indicating whether the application fee should be refunded when refunding this charge.
metadata               | false    | array  | []      | A set of key/value pairs that you can attach to a refund object.

```php
$charge = Stripe::refunds()->create([
	'charge' => 'ch_4ECWMVQp5SJKEx',
]);
```

#### Retrieve all refunds of a charge

You can see a list of the refunds belonging to a specific charge.

##### Arguments

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
charge         | true     | string | null    | The charge unique identifier.
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

#### Retrieve an existing refund

By default, you can see the 10 most recent refunds stored on a charge directly on the charge object, but you can also retrieve details about a specific refund stored on the charge.

##### Arguments

Key    | Required | Type   | Default | Description
------ | -------- | ------ | ------- | -----------------------------------------
charge | true     | string | null    | The charge unique identifier.
id     | true     | string | null    | The refund unique identifier.

```php
$refund = Stripe::refunds()->find([
	'charge' => 'ch_4ECWMVQp5SJKEx',
	'id'     => 'txn_4IgdBGArAOeiQw',
]);
```

###### Using the alias

```php
$charge = Stripe::refund('ch_4ECWMVQp5SJKEx', 'txn_4IgdBGArAOeiQw');
```

#### Update an existing refund

Updates the specified refund by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

##### Arguments

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
charge   | true     | string | null    | The charge unique identifier.
id       | true     | string | null    | The refund unique identifier.
metadata | false    | array  | []      | A set of key/value pairs that you can attach to a refund object.

```php
$refund = Stripe::refunds()->update([
	'charge'   => 'ch_4ECWMVQp5SJKEx',
	'id'       => 'txn_4IgdBGArAOeiQw',
	'metadata' => [
		'reason'      => 'Customer requested for the refund.',
		'refunded_by' => 'John Doe',
	],
]);
```
