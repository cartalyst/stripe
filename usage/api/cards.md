## Cards

### Create a new card

Key      | Required | Type            | Default | Description
-------- | -------- | --------------- | ------- | ------------------------------
customer | true     | string          | null    | The customer unique identifier.
card     | true     | string or array | null    | The card unique identifier.

```php
$card = Stripe::cards()->create([
	'customer' => 'cus_4DArhxP7RAFBaB',
	'card'     => [
		'number'    => '4242424242424242',
		'exp_month' => 6,
		'exp_year'  => 2015,
		'cvc'       => '314',
	],
]);
```

Via Stripe.js plugin

```php
$cardToken = Input::get('stripeToken');

$card = Stripe::cards()->create([
	'customer' => 'cus_4DArhxP7RAFBaB',
	'card'     => $cardToken,
]);
```

### Update a card

Key           | Required | Type   | Default | Description
------------- | -------- | ------ | ------- | ----------------------------------
id            | true     | string | null    | The card unique identifier.
customer      | true     | string | null    | The customer unique identifier.
name          | false    | string | null    | The card holder name.
address_city  | false    | string | null    | The card holder city.
address_line1 | false    | string | null    | The card holder address line 1.
address_line2 | false    | string | null    | The card holder address line 2.
address_state | false    | string | null    | The card holder state.
address_zip   | false    | string | null    | The card holder address zip code.
exp_month     | false    | string | null    | The card expiration month.
exp_year      | false    | string | null    | The card expiration year.

```php
$card = Stripe::cards()->update([
	'id'            => 'card_4EBj4AslJlNXPs',
	'customer'      => 'cus_4DArhxP7RAFBaB',
	'name'          => 'John Doe',
	'address_line1' => 'Example Street 1',
]);
```

### Delete a card

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
id       | true     | string | null    | The card unique identifier.
customer | true     | string | null    | The customer unique identifier.

```php
$card = Stripe::cards()->destroy([
	'id'       => 'card_4EBi3uAIBFnKy4',
	'customer' => 'cus_4DArhxP7RAFBaB',
]);
```

### Retrieve all cards

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
id             | true     | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$cards = Stripe::cards()->all([
	'customer' => 'cus_4DArhxP7RAFBaB',
]);

foreach ($cards['data'] as $card)
{
	var_dump($card['id']);
}
```

### Retrieve a Card

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
id       | true     | string | null    | The card unique identifier.
customer | true     | string | null    | The customer unique identifier.

```php
$card = Stripe::cards()->find([
	'id'       => 'card_4DmaB3muM8SNdZ',
	'customer' => 'cus_4DArhxP7RAFBaB',
]);

echo $card['id'];
```
