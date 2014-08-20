### Attaching

In a scenario where you already have your Stripe customers but you don't have them attached to entities on local storage you would obviously be wanting for an easy and fast way to attach them.

With this scenario in mind, we've two methods implemented that will help you to attach all the Stripe customers at once or a single Stripe customer at a time with the ability to syncronize all their related data like cards, charges, invoices and subscriptions.

Please refer to the following sections for a better understanding and example of usage.

#### Attach a single Stripe Customer

You have a Stripe customer and you want to attach that Stipe customer to an entity you have stored locally, to make it easy, we've the `attachStripeCustomer()` method that will do this job for you and it'll syncronize all the related data automatically using the `syncWithStripe()`.

##### Arguments

Key   | Required | Type                          | Default | Description
----- | -------- | ----------------------------- | ------- | -----------------------------------------------------------
$data | true     | Cartalyst\Stripe\Api\Response | null    | The Stripe customer data.
$sync | false    | bool                          | true    | If it should syncronize the related data.

##### Example

```php
// Get the Stripe customer
$customer = Stripe::customer('cus_4EBumIjyaKooft');

// Get the entity and attach the Stripe customer
$entity = User::where('email', $customer['email'])->first();
$entity->attachStripeCustomer($customer);
```

#### Attach all Stripe Customers

Attaching all Stripe customers is even easier and internally it works exactly like the `attachStripeCustomer()` method with the main difference that you need to pass a `Closure` and return the entity from within the `Closure`.

The entity that is returned from the `Closure` needs to be the entity that will be used to attach the Stripe customer that is passed through the `$customer` argument on the `Closure` to the entity you return, so you can use any information you see fit on your application to search for the proper entity using the `$customer` object.

##### Arguments

Key       | Required | Type    | Default | Description
--------- | -------- | ------- | ------- | -------------------------------------
$callback | true     | Closure | null    | A Closure that should return a `Cartalyst\Stripe\Billing\BillableInterface` object.
$sync     | false    | bool    | true    | If it should syncronize the related data.

##### Example

```php
use Cartalyst\Stripe\Api\Response;

User::attachStripeCustomers(function(Response $customer)
{
	return User::where('email', $customer['email'])->first();
});
```
