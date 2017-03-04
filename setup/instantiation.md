### Instantiation

Creating a new Stripe instance is very easy and straightforward. Please check the examples below for further explanation.

```php
use Cartalyst\Stripe\Stripe;

$stripe = new Stripe('your-stripe-api-key', 'your-stripe-api-version');
```

```php
use Cartalyst\Stripe\Stripe;

$stripe = Stripe::make('your-stripe-api-key', 'your-stripe-api-version');
```

You can use environment variables instead of passing them as arguments, like so:

```php
putenv('STRIPE_API_KEY=your-stripe-api-key');

putenv('STRIPE_API_VERSION=your-stripe-api-version');
```

Then upon instantiation, Stripe will auto detect these and use accordingly.

```php
use Cartalyst\Stripe\Stripe;

$stripe = new Stripe();
```

```php
$stripe = Stripe::make();
```

> **Note:** Please do note that the Stripe API KEY is always required to be defined, either through an environment variable or by passing it as the first argument.
