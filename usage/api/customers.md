### Customers

Customer objects allow you to perform recurring charges and track multiple charges that are associated with the same customer. The API allows you to create, delete, and update your customers. You can retrieve individual customers as well as a list of all your customers.

#### Create a new customer

Key             | Required | Type            | Default | Description
--------------- | -------- | --------------- | ------- | -----------------------
account_balance | false    | number          | null    | A positive amount that is the starting account balance for your customer.
card            | false    | string or array | null    | Unique card identifier (can either be an ID or a hash).
coupon          | false    | string          | null    | Coupon identifier that applies a discount on all recurring charges.
plan            | false    | string          | null    | Plan for the customer.
quantity        | false    | integer         | null    | Quantity you'd like to apply to the subscription you're creating.
trial_end       | false    | integer         | null    | UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.
description     | false    | string          | null    | An arbitrary string that you can attach to a customer object.
email           | false    | string          | null    | Customer’s email address.
metadata        | false    | array           | null    | A set of key/value pairs that you can attach to a customer object.

```php
$customer = Stripe::customers()->create([
	'email' => 'john.doe@example.com',
]);

echo $customer['id'];
```

#### Delete a customer

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The customer unique identifier.

```php
$customer = Stripe::customers()->destroy([
	'id' => 'cus_4EBxvk6aBPexFO',
]);
```

#### Update a customer

Key             | Required | Type            | Default | Description
--------------- | -------- | --------------- | ------- | -----------------------
id              | true     | string          | null    | The customer unique identifier.
account_balance | false    | number          | null    | A positive amount that is the starting account balance for your customer.
card            | false    | string or array | null    | Unique card identifier (can either be an ID or a hash).
coupon          | false    | string          | null    | Coupon identifier that applies a discount on all recurring charges.
plan            | false    | string          | null    | Plan for the customer.
description     | false    | string          | null    | An arbitrary string that you can attach to a customer object.
email           | false    | string          | null    | Customer’s email address.
metadata        | false    | array           | null    | A set of key/value pairs that you can attach to a customer object.

```php
$customer = Stripe::customers()->update([
	'id'    => 'cus_4EBumIjyaKooft',
	'email' => 'jonathan@doe.com',
]);

echo $customer['email'];
```

#### Retrieve all customers

Key             | Required | Type            | Default | Description
--------------- | -------- | --------------- | ------- | -----------------------
created         | false    | string or array | null    | A filter based on the "created" field. Can be an exact UTC timestamp, or an hash.
ending_before   | false    | string          | null    | A cursor to be used in pagination.
limit           | false    | integer         | 10      | A limit on the number of objects to be returned. Limit can range between 1 and 100 items.
starting_after  | false    | string          | null    | A cursor to be used in pagination.

```php
$customers = Stripe::customers()->all();

foreach ($customers['data'] as $customer)
{
	var_dump($customer['id']);
}
```

#### Retrieve a customer

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | -------------------------------------------
id  | true     | string | null    | The customer unique identifier.

```php
$customer = Stripe::customers()->find([
	'id' => 'cus_4EBumIjyaKooft',
]);

echo $customer['email'];
```

#### Delete a customer discount

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | -------------------------------------------
id  | true     | string | null    | The customer unique identifier.

```php
$customer = Stripe::customers()->deleteDiscount([
	'id' => 'cus_4EBumIjyaKooft',
])->findArray();
```
