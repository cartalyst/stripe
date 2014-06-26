## Disputes

### Close a dispute

Key    | Required | Type   | Default | Description
------ | -------- | ------ | ------- | -----------------------------------------
charge | true     | string | null    | The charge unique identifier.

```php
$dispute = Stripe::disputes()->close([
	'charge' => 'ch_4ECWMVQp5SJKEx',
]);
```

### Update a dispute

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
charge   | true     | string | null    | The charge unique identifier.
evidence | false    | string | null    | An evidence that you can attach to a dispute object.
metadata | false    | array  | []      | A set of key/value pairs that you can attach to a dispute object.

```php
$dispute = Stripe::disputes()->update([
	'charge'   => 'ch_4ECWMVQp5SJKEx',
	'evidence' => 'Customer agreed to drop the dispute.',
]);
```
