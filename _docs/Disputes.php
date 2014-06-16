## Disputes

### Close a dispute

```php
$dispute = Stripe::disputes()->close([
	'charge' => 'ch_4ECWMVQp5SJKEx',
]);
```

### Update a dispute

```php
$dispute = Stripe::disputes()->update([
	'charge'   => 'ch_4ECWMVQp5SJKEx',
	'evidence' => 'Customer agreed to drop the dispute.',
]);
```
