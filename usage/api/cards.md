### Cards

You can store multiple cards on a customer in order to charge the customer later. You can also store multiple debit cards on a recipient in order to transfer to those cards later.

#### Create a new card

When you create a new credit card, you must specify a customer to create it on.

Creating a new credit card will not change the card owner's existing default credit card. If the card's owner has no default credit card, the added credit card will become the default.

Key      | Required | Type            | Default | Description
-------- | -------- | --------------- | ------- | ------------------------------
customer | true     | string          | null    | The customer unique identifier.
card     | true     | string or array | null    | The card unique identifier.

###### Through the Stripe.js Token (recommended)

```php
$cardToken = Input::get('stripeToken');

$card = Stripe::cards()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'card'     => $cardToken,
]);
```

###### Manually

```php
$card = Stripe::cards()->create([
	'customer' => 'cus_4EBumIjyaKooft',
	'card'     => [
		'number'    => '4242424242424242',
		'exp_month' => 6,
		'exp_year'  => 2015,
		'cvc'       => '314',
	],
]);
```

#### Update a card

If you need to update only some card details, like the billing address or expiration date, you can do so without having to re-enter the full card details.

When you update a card, Stripe will automatically validate the card.

Key           | Required | Type   | Default | Description
------------- | -------- | ------ | ------- | ----------------------------------
customer      | true     | string | null    | The customer unique identifier.
id            | true     | string | null    | The card unique identifier.
address_city  | false    | string | null    | The card holder city.
address_line1 | false    | string | null    | The card holder address line 1.
address_line2 | false    | string | null    | The card holder address line 2.
address_state | false    | string | null    | The card holder state.
address_zip   | false    | string | null    | The card holder address zip code.
exp_month     | false    | string | null    | The card expiration month.
exp_year      | false    | string | null    | The card expiration year.
name          | false    | string | null    | The card holder name.

```php
$card = Stripe::cards()->update([
	'customer'      => 'cus_4EBumIjyaKooft',
	'id'            => 'card_4EBj4AslJlNXPs',
	'name'          => 'John Doe',
	'address_line1' => 'Example Street 1',
]);
```

#### Delete a card

You can delete cards from a customer.

If you delete a card that is currently the default card on a customer, the most recently added card will be used as the new default.

If you delete the last remaining card on a customer, the default_card attribute on the card's owner will become null.

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
customer | true     | string | null    | The customer unique identifier.
id       | true     | string | null    | The card unique identifier.

```php
$card = Stripe::cards()->destroy([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'card_4EBi3uAIBFnKy4',
]);
```

#### Retrieve all cards

You can see a list of the cards belonging to a customer.

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
customer       | true     | string | null    | The customer unique identifier.
id             | true     | string | null    | The customer unique identifier.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$cards = Stripe::cards()->all([
	'customer' => 'cus_4EBumIjyaKooft',
]);

foreach ($cards['data'] as $card)
{
	var_dump($card['id']);
}
```

#### Retrieve a Card

Retrieves the details of an existing credit card.

Key      | Required | Type   | Default | Description
-------- | -------- | ------ | ------- | ---------------------------------------
customer | true     | string | null    | The customer unique identifier.
id       | true     | string | null    | The card unique identifier.

```php
$card = Stripe::cards()->find([
	'customer' => 'cus_4EBumIjyaKooft',
	'id'       => 'card_4DmaB3muM8SNdZ',
]);

echo $card['last4'];
```

###### Using the alias

```php
$charge = Stripe::card('cus_4EBumIjyaKooft', 'card_4DmaB3muM8SNdZ');
```
