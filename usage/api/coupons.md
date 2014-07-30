### Coupons

A coupon contains information about a percent-off discount you might want to apply to a customer. Coupons only apply to invoices created for recurring subscriptions and invoice items; they do not apply to one-off charges.

#### Create a new coupon

You can create coupons easily via the [coupon management](https://dashboard.stripe.com/coupons) page of the Stripe dashboard. Coupon creation is also accessible via the API if you need to create coupons on the fly.

A coupon has either a `percent_off` or an `amount_off` and `currency`. If you set an `amount_off`, that amount will be subtracted from any invoice's subtotal. For example, an invoice with a subtotal of $10 will have a final total of $0 if a coupon with an `amount_off` of 2000 is applied to it and an invoice with a subtotal of $30 will have a final total of $10 if a coupon with an `amount_off` of 2000 is applied to it.

Key                | Required | Type   | Default | Description
------------------ | -------- | ------ | ------- | -----------------------------
id                 | false    | string | null    | The coupon unique identifier, if not provided a random string will be generated.
duration           | true     | string | null    | Specifies how long the discount will be in effect. Can be forever, once, or repeating.
amount_off         | false    | number | null    | A positive amount representing the amount to subtract from an invoice total (required if percent_off is not passed).
currency           | true     | string | null    | 3-letter ISO code for currency.
duration_in_months | false    | int    | null    | If duration is repeating, a positive integer that specifies the number of months the discount will be in effect.
max_redemptions    | false    | int    | null    | A positive integer specifying the number of times the coupon can be redeemed before it’s no longer valid.
metadata           | false    | array  | []      | A set of key/value pairs that you can attach to a coupon object.
percent_off        | false    | int    | null    | A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed).
redeem_by          | false    | int    | null    | Unix timestamp specifying the last time at which the coupon can be redeemed.

```php
$coupon = Stripe::coupons()->create([
	'id'          => '50-PERCENT-OFF',
	'duration'    => 'forever',
	'percent_off' => 50,
]);

echo $coupon['id'];
```

#### Delete a coupon

You can delete coupons via the [coupon management](https://dashboard.stripe.com/coupons) page of the Stripe dashboard. However, deleting a coupon does not affect any customers who have already applied the coupon; it means that new customers can't redeem the coupon. You can also delete coupons via the API.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The coupon unique identifier.

```php
$coupon = Stripe::coupons()->destroy([
	'id' => '50-PERCENT-OFF',
]);
```

#### Retrieve all the existing coupons

Returns a list of your coupons.

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$coupons = Stripe::coupons()->all();

foreach ($coupons['data'] as $coupon)
{
	var_dump($coupon['id']);
}
```

#### Retrieve an existing coupon

Retrieves the coupon with the given ID.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The coupon unique identifier.

```php
$coupon = Stripe::coupons()->find([
	'id' => '50-PERCENT-OFF',
]);

echo $coupon['percent_off'];
```
