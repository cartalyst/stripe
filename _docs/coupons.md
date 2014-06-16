## Coupons

### Create a new coupon

```php
$coupon = Stripe::coupons()->create([
	'id'          => '50-PERCENT-OFF',
	'duration'    => 'forever',
	'percent_off' => 50,
])->toArray();

echo $coupon['id'];
```

### Delete a coupon

```php
$coupon = Stripe::coupons()->delete([
	'id' => '50-PERCENT-OFF',
])->toArray();
```

### Retrieve all the coupons

```php
$coupons = Stripe::coupons()->all()->toArray();

foreach ($coupons['data'] as $coupon)
{
	var_dump($coupon['id']);
}
```

### Retrieve a coupon

```php
$coupon = Stripe::coupons()->find([
	'id' => '50-PERCENT-OFF',
])->toArray();

echo $coupon['id'];
```
