## Pagination

Handling pagination on APIs is very hard and instead of manually handling the pagination, the Stripe package comes with a resource iterator which handles all of this for you, automatically!

Here is an example of grabbing all the customers:

```php
$customers = Stripe::customersIterator();

foreach ($customers as $customer)
{
	var_dump($customer['id']);
}
```

You can still pass any API argument as you would with any normal API method:

```php
$customers = Stripe::customersIterator([
	'created' => 123456789,
]);

foreach ($customers as $customer)
{
	var_dump($customer['id']);
}
```

### Set results limit

If you have the need to lock the number of results, you can achieve this by using the `->setLimit(:amount);` method:

```php
$customers = Stripe::customersIterator();
$customers->setLimit(30);

foreach ($customers as $customer)
{
	var_dump($customer['id']);
}
```

In this example, it will only return 30 results.

### Set results per page

Setting a number of results per page is very easy and very similar to the results limit "locking", you just need to use the `->setPageSize(:amount);` method:

```php
$customers = Stripe::customersIterator();
$customers->setPageSize(50);

foreach ($customers as $customer)
{
	var_dump($customer['id']);
}
```

> **Note:** The max results per page that Stripe allows is 100.
