# Introduction

A comprehensive billing and API package for Stripe.

The package requires PHP 5.4+ and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP code and is fully unit-tested.

Have a [read through the Installation Guide](#installation) and on how to [Integrate it with Laravel 4](#laravel-4).

### Quick Example

**Using the API**

```php
$customers = Stripe::customers()->all();

foreach ($customers['data'] as $customer)
{
	var_dump($customer['email']);
}
```

**Using a Billable Entity**

```php
$user = User::find(1);

$subscriptions = $user->subscriptions;

foreach ($subscriptions as $subscription)
{
	if ($subscription->expired())
	{
		echo 'Subscription has expired!';
	}
}
```
