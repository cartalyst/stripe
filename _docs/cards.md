## Cards

### Create a new card

Create a new credit card and attach it to a customer.

```php
$token = Stripe::tokens()->create([
	'card' => [
		'number'    => '4242424242424242',
		'exp_month' => 6,
		'exp_year'  => 2015,
		'cvc'       => '314'
	],
])->toArray();

$card = Stripe::cards()->create([
	'customer' => 'cus_4DArhxP7RAFBaB',
	'card'     => $token['id'],
])->toArray();
```

Via Stripe.js plugin

```php
$cardToken = Input::get('stripeToken');

$response = Stripe::cards()->create([
	'customer' => 'cus_4DArhxP7RAFBaB',
	'card'     => $cardToken,
]);

### Update a card

```php
$card = Stripe::cards()->find([
	'id'            => 'card_4EBj4AslJlNXPs',
	'customer'      => 'cus_4DArhxP7RAFBaB',
	'name'          => 'John Doe',
	'address_line1' => 'Example Street 1',
])->toArray();
```

### Delete a card

```php
$response = Stripe::cards()->delete([
	'id'       => 'card_4EBi3uAIBFnKy4',
	'customer' => 'cus_4DArhxP7RAFBaB',
])->toArray();
```

### Retrieve all cards

Fetch all the cards attached to a customer.

#### Laravel

```php
$cards = Stripe::cards()->all(['customer' => 'cus_4DArhxP7RAFBaB'])->toArray();

foreach ($cards['data'] as $card)
{
	var_dump($card['id']);
}
```

#### Native

```php
$cards = $stripe->cards()->all([
	'customer' => 'cus_4DArhxP7RAFBaB',
])->toArray();

foreach ($cards['data'] as $card)
{
	var_dump($card['id']);
}
```

### Retrieve a Card

Fetch a card that is attached to a customer.

#### Laravel

```php
$card = Stripe::cards()->find([
	'id'       => 'card_4DmaB3muM8SNdZ',
	'customer' => 'cus_4DArhxP7RAFBaB',
])->toArray();

echo $card['id'];
```

#### Native

```php
$card = $stripe->cards()->find([
	'id'       => 'card_4DmaB3muM8SNdZ',
	'customer' => 'cus_4DArhxP7RAFBaB',
])->toArray();

echo $card['id'];
```
