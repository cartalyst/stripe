### Tokens

Often you want to be able to charge credit cards or send payments to bank accounts without having to hold sensitive card information on your own servers. Stripe.js makes this easy in the browser, but you can use the same technique in other environments with our token API.

#### Create a card token

Creates a single use token that wraps the details of a credit card. This token can be used in place of a credit card dictionary with any API method. These tokens can only be used once: by [creating a new charge object](#create-a-new-charge), or attaching them to a [customer](#create-a-new-customer).

##### Arguments

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

#### Create a bank account token

Creates a single use token that wraps the details of a bank account. This token can be used in place of a bank account dictionary with any API method. These tokens can only be used once: by attaching them to a [recipient](#create-a-new-recipient).

##### Arguments

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
