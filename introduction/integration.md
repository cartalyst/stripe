# Integration

## Laravel 4

### Migrations

Just run the following command

```php
php artisan migrate --package=cartalyst/stripe
```

### Model setup

Add the BillableTrait to your model:

```php
use Cartalyst\Stripe\BillableTrait;
use Cartalyst\Stripe\BillableInterface;

class User extends Eloquent implements BillableInterface {

	use BillableTrait;

}
```

### Set the Stripe Key

First and recommended option is to add the stripe key into the `app/config/services.php` file, just follow the example

```php
<?php

return [

	'stripe' => [
		'secret' => 'your-stripe-key-here',
	],

];
```

> **Note:** In case you don't have this file, you can simply create it.

Second option is to setup the Stripe key in one of your bootstrap files:

```php
User::setStripeKey('your-stripe-key');
```
