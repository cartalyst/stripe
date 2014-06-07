## Charges

### Listing the charges

```php
$user = User::find(1);

$charges = $user->charges;
```

### Creating charges

```php
$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Creating a charge to be captured later.

```php
$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->disableCapture()
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Creating a charge with a new credit card.

```php
$token = Input::get('stripeToken');

$user = User::find(1);

$amount = 150.95;

$user
	->charge()
	->setToken($token)
	->create($amount, [
		'description' => 'Purchased Book!',
	]);
```

Capturing a charge.

```php
$user = User::find(1);

$user
	->charge(10)
	->capture();
```

### Refund charges

Do a full refund

```php
$user = User::find(1);

$user
    ->charge(10)
    ->refund();
```

Do a partial refund

```php
$user = User::find(1);

$amount = 50.00;

$user
    ->charge(10)
    ->refund($amount);
```

### Sync data from Stripe

Often you might have the need to sync the data from Stripe with your database, we have an easy way to achieve this.

```php
$user = User::find(1);

$user
	->charge()
	->syncWithStripe();
```

> **Note:** You can pass a charge id `integer` or a `Cartalyst\Stripe\Charge\IlluminateCharge` object through the `charge()` method.
