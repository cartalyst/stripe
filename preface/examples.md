### Examples

###### Retrieve all customers

```php
$customers = Stripe::customers()->all();

foreach ($customers['data'] as $customer)
{
    var_dump($customer['email']);
}
```

###### Retrieve a customer

```php
$customer = Stripe::customers()->find('cus_4EBumIjyaKooft');

echo $customer['email'];
```
