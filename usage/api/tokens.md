## Tokens

### Create a card token

Key      | Required | Type            | Default | Description
-------- | -------- | --------------- | ------- | ------------------------------
card     | true     | string or array | null    | The card unique identifier.
customer | false    | string          | null    | A customer to create a token for.

```php
$token = Stripe::tokens()->create([
	'card' => [
		'number'    => '4242424242424242',
		'exp_month' => 6,
		'exp_year'  => 2015,
		'cvc'       => 314,
	],
]);

echo $token['id'];
```

### Create a bank account token

Key          | Required | Type  | Default | Description
------------ | -------- | ----- | ------- | ------------------------------------
bank_account | true     | array | null    | A bank account to attach to the recipient.

```php
$token = Stripe::tokens()->create([
	'bank_account' => [
		'country'        => 'US',
		'routing_number' => '110000000',
		'account_number' => '000123456789',
	],
]);

echo $token['id'];
```
