### Pagination

Handling pagination on APIs is very hard and instead of manually handling the pagination, the Stripe package comes with a resource iterator which handles all of this for you, automatically!

Here is an example of grabbing all the customers:

```php
$customers = $stripe->customersIterator();

foreach ($customers as $customer) {
	var_dump($customer['id']);
}
```

You can still pass any API argument as you would with any normal API method:

```php
$customers = $stripe->customersIterator([
	'created' => 123456789,
]);

foreach ($customers as $customer) {
	var_dump($customer['id']);
}
```
