### Synchronization

#### Synchronize all the entities

```php
User::syncStripeCustomers(function($customer)
{
	return User::where('stripe_id', $customer['id'])->first();
});
```

#### Synchronize a single entity

If you have the need to completely have your local data in sync with the Stripe data, you can use the `syncWithStripe()` method.

This will syncronize up the cards, charges, invoices and their invoice items, the pending invoice items and subscriptions that belongs to your entity.

##### Example

```php
$user = User::find(1);

$user->syncWithStripe();
```
