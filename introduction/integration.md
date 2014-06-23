# Integration

## Laravel 4

The Stripe package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.

After installing the package, open your Laravel config file located at `app/config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

	'Cartalyst\Stripe\Laravel\StripeServiceProvider',

In the `$aliases` array add the following facade for this package.

	'Stripe' => 'Cartalyst\Stripe\Laravel\Facades\Stripe',

### Migrations

Just run the following command

```php
php artisan migrate --package=cartalyst/stripe
```

### Model setup

Add the `BillableTrait` to your model:

```php
use Cartalyst\Stripe\BillableTrait;
use Cartalyst\Stripe\BillableInterface;

class User extends Eloquent implements BillableInterface {

	use BillableTrait;

}
```

### Set the Stripe API Key

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

