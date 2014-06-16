## Tokens

### Create a card token

```php
$token = Stripe::tokens()->create([
	'card' => [
		'number'    => '4242424242424242',
		'exp_month' => 6,
		'exp_year'  => 2015,
		'cvc'       => '314',
	],
])->toArray();

echo $token['id'];
```

### Create a bank account token

```php
$token = Stripe::tokens()->create([
	'bank_account' => [
		'country'        => 'US',
		'routing_number' => '110000000',
		'account_number' => '000123456789',
	],
])->toArray();

echo $token['id'];
```
