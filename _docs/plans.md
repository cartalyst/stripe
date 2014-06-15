## Plans

### Create a new plan

```php
$response = Stripe::plans()->create([
	'id'                    => 'monthly',
	'name'                  => 'Monthly (30$)',
	'amount'                => 3000, // 30.00$
	'currency'              => 'USD',
	'interval'              => 'month',
	'statement_description' => 'Monthly Subscription to Foo Bar Inc.',
]);
```

### Delete a plan

```php
$response = Stripe::plans()->delete([
	'id' => 'monthly',
]);
```

### Update a plan

```php
$response = Stripe::plans()->update([
	'id'   => 'monthly',
	'name' => 'Monthly Subscription',
]);
```
