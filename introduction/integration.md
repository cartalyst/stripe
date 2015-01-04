## Integration

Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.

### Laravel 4

The Stripe package has optional support for Laravel 4 and it comes bundled with a Service Provider and a Facade for easy integration.

After installing the package, open your Laravel config file located at `app/config/app.php` and add the following lines.

In the `$providers` array add the following service provider for this package.

	'Cartalyst\Stripe\Laravel\StripeServiceProvider',

In the `$aliases` array add the following facade for this package.

	'Stripe' => 'Cartalyst\Stripe\Laravel\Facades\Stripe',

#### Set the Stripe API Key

Now you need to setup the Stripe API key, to do this open or create the `app/config/services.php` file, and add or update the `'stripe'` array:

```php
<?php

return [

	'stripe' => [
		'secret' => 'your-stripe-key-here',
	],

];
```
