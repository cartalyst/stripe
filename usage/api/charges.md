## Charges

### Create a new charge

Key                   | Required | Type            | Default | Description
--------------------- | -------- | --------------- | ------- | --------------------------------------------
amount                | true     | int             | null    | A positive integer in the smallest currency unit.
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
$charge = Stripe::charges()->update([
	'customer' => 'cus_4EBumIjyaKooft',
	'currency' => 'USD',
	'amount'   => 5049, # $50.49
])->toArray();

echo $charge['id'];
```

### Update a charge

Key         | Required | Type   | Default | Description
----------- | -------- | ------ | ------- | --------------------------------------------
id          | true     | string | null    | The charge unique identifier.
description | false    | string | null    | An arbitrary string which you can attach to a charge object.
metadata    | false    | array  | []      | A set of key/value pairs that you can attach to a charge object.

```php
$charge = Stripe::charges()->update([
	'id'          => 'ch_4ECWMVQp5SJKEx',
	'description' => 'Payment to foo bar',
])->toArray();
```

### Capture a charge

Key             | Required | Type   | Default | Description
--------------- | -------- | ------ | ------- | --------------------------------------------
id              | true     | string | null    | The charge unique identifier.
amount          | false    | int    | null    | A positive integer in the smallest currency unit.
application_fee | false    | int    | null    | An application fee to add on to this charge.
receipt_email   | false    | string | null    | The email address to send this charge’s receipt to.

```php
$charge = Stripe::charges()->capture([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```

### Refund a charge

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The charge unique identifier.

```php
$charge = Stripe::charges()->refund([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```

### Retrieve all charges

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | --------------------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
customer       | false    | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$charges = Stripe::charges()->all()->toArray();

foreach ($charges['data'] as $charge)
{
	var_dump($charge['id']);
}
```

### Retrieve an existing charge

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The charge unique identifier.

```php
$charge = Stripe::charges()->find([
	'id' => 'ch_4ECWMVQp5SJKEx',
])->toArray();
```
