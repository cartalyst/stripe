## Coupons

### Create a new coupon

Key                | Required | Type   | Default | Description
------------------ | -------- | ------ | ------- | -----------------------------
id                 | true     | string | null    | The coupon unique identifier.
duration           | true     | string | null    | Specifies how long the discount will be in effect. Can be forever, once, or repeating.
amount_off         | false    | int    | null    | A positive integer representing the amount to subtract from an invoice total (required if percent_off is not passed).
currency           | true     | string | null    | 3-letter ISO code for currency.
duration_in_months | false    | int    | null    |  If duration is repeating, a positive integer that specifies the number of months the discount will be in effect.
max_redemptions    | false    | int    | null    | A positive integer specifying the number of times the coupon can be redeemed before it’s no longer valid.
metadata           | false    | array  | []      | A set of key/value pairs that you can attach to a coupon object.
percent_off        | false    | int    | null    | A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed).
redeem_by          | false    | int    | null    | Unix timestamp specifying the last time at which the coupon can be redeemed.

```php
$coupon = Stripe::coupons()->create([
	'id'          => '50-PERCENT-OFF',
	'duration'    => 'forever',
	'percent_off' => 50,
])->toArray();

echo $coupon['id'];
```

### Delete a coupon

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The coupon unique identifier.

```php
$coupon = Stripe::coupons()->delete([
	'id' => '50-PERCENT-OFF',
])->toArray();
```

### Retrieve all the existing coupons

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$coupons = Stripe::coupons()->all()->toArray();

foreach ($coupons['data'] as $coupon)
{
	var_dump($coupon['id']);
}
```

### Retrieve an existing coupon

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The coupon unique identifier.

```php
$coupon = Stripe::coupons()->find([
	'id' => '50-PERCENT-OFF',
])->toArray();

echo $coupon['id'];
```
