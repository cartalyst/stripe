## Coupons

### Create a new coupon

```php
$response = Stripe::coupons()->create([
	'id'          => '50-PERCENT-OFF',
	'duration'    => 'forever',
	'percent_off' => 50,
]);
```

### Delete a coupon

```php
$response = Stripe::coupons()->delete([
	'id' => '50-PERCENT-OFF',
]);
```

### Retrieve all the coupons

```php
$response = Stripe::coupons()->all();
```

### Retrieve a coupon

```php
$response = Stripe::coupons()->find([
	'id' => '50-PERCENT-OFF',
]);
```
