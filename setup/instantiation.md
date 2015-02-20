### Instantiation

Creating a new Stripe instance is very and straightforward and there is only one argument that is required to be passed, an `api_key` and an optional `api_version`.

#### Usage

```php
$stripe = new Stripe('your-stripe-api-key', 'your-stripe-api-version');
```

```php
$stripe = Stripe::make('your-stripe-api-key', 'your-stripe-api-version');
```

You can use environment variables instead of passing them as arguments, like so:

```php
putenv('STRIPE_API_KEY=your-stripe-api-key');

putenv('STRIPE_API_VERSION=your-stripe-api-version');
```

Then upon instantiation, Stripe will auto detect these and use accordingly.

```php
$stripe = new Stripe;
```

```php
$stripe = Stripe::make();
```
