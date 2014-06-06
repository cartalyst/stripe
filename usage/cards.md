## Credit Cards

### Listing the attached cards

Listing the attached cards from an user is very easy.

```php
$user = User::find(1);

$cards = $user->cards;
```

### Attaching credit cards

Attach a new credit card to the user.

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->card()
	->create($token);
```

Attach a new credit card to the user and make it the default credit card.

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$user
	->card()
	->makeDefault()
	->create($token);
```

### Updating credit cards

Update a credit card.

```php
$user = User::find(1);

$attributes = [
	'name' => 'John Doe',
];

$user
	->card(10)
	->update($attributes);
```

Make an existing credit card the default credit card.

```php
$user = User::find(1);

$user
	->card(10)
	->setDefault();
```

### Deleting credit cards

```php
$user = User::find(1);

$user
	->card(10)
	->delete();
```

### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->card()
	->syncWithStripe();
```

> **Note:** You can pass a card id `integer` or a `Cartalyst\Stripe\Card\IlluminateCard` object through the `card()` method.
