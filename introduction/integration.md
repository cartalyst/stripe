# Integration

## Laravel 4

The Stripe package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.

After installing the package, open your Laravel config file located at `app/config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

	'Cartalyst\Stripe\Laravel\StripeServiceProvider',

In the `$aliases` array add the following facade for this package.

	'Stripe' => 'Cartalyst\Stripe\Laravel\Facades\Stripe',

### Set the Stripe API Key

Now you need to setup the Stripe API key, to do this open or create the `app/config/services.php` file, and add or update the `'stripe'` array:

```php
<?php

return [

	'stripe' => [
		'secret' => 'your-stripe-key-here',
	],

];
```

### Billing

The Stripe package comes with billing functionality that you can attach to any entity.

To use this feature please follow the next steps:

#### Migrations

Now you need to migrate your database, but before doing that, you'll need to generate a migration that suits your billable table and to do this you just need to run the following command:

	php artisan stripe:migrator users

> **Note:** Replace `users` with the billable entity table name.

Now that the migration file is created you just need to run `php artisan migrate` to create the tables on your database.

#### Model setup

Add the `BillableTrait` to your Eloquent model and make sure the model implements the `BillableInterface`:

```php
use Cartalyst\Stripe\Billing\BillableTrait;
use Cartalyst\Stripe\Billing\BillableInterface;

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
