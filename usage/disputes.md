### Disputes

A dispute occurs when a customer questions your charge with their bank or credit card company. When a customer disputes your charge, you're given the opportunity to respond to the dispute with evidence that shows the charge is legitimate.

#### Close a dispute

##### Arguments

Key    | Required | Type   | Default | Description
------ | -------- | ------ | ------- | -----------------------------------------
charge | true     | string | null    | The charge unique identifier.

```php
$dispute = Stripe::disputes()->close([
	'charge' => 'ch_4ECWMVQp5SJKEx',
]);
```

#### Update a dispute

##### Arguments

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
