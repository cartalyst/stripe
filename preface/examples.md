### Examples

###### Retrieve all customers

```php
$stripe = Stripe::make('your-stripe-api-key');

$customers = $stripe->customers()->all();

foreach ($customers['data'] as $customer)
{
    var_dump($customer['email']);
}
```

###### Retrieve a customer

```php
$stripe = Stripe::make('your-stripe-api-key');

$customer = $stripe->customers()->find('cus_4EBumIjyaKooft');

echo $customer['email'];
```
