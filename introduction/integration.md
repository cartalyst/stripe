# Integration

## Laravel 4

The Stripe package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.

After installing the package, open your Laravel config file located at `app/config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

	'Cartalyst\Stripe\Laravel\StripeServiceProvider',

In the `$aliases` array add the following facade for this package.

	'Stripe' => 'Cartalyst\Stripe\Laravel\Facades\Stripe',

### Set the Stripe API Key

Now you need to setup the Stripe API key, to do this open or create the `app/config/services.php` file, and update or add the `'stripe'` array:

```php
<?php

return [

	'stripe' => [
		'secret' => 'your-stripe-key-here',
	],

];
```

### Billing

If you want to use the billing features, please follow the next steps:

#### Migrations

Just run the following command

```php
php artisan migrate --package=cartalyst/stripe
```

#### Model setup

Add the `BillableTrait` to your model:

```php
use Cartalyst\Stripe\BillableTrait;
use Cartalyst\Stripe\BillableInterface;

class User extends Eloquent implements BillableInterface {

	use BillableTrait;

}
```

Open the `app/config/services.php` file and add a new `'model'` entry on the `'stripe'` array that will hold your entity model class name:

```php
return [

	'stripe' => [
		'secret' => 'your-stripe-key-here',
		'model'  => 'User',
	],

];
```

> **Note:** If your model is under a namespace, please provide the full namespace, ex: `'Acme\Models\User'`.
