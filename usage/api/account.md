## Account

Retrieve information about your Stripe account.

```php
$account = Stripe::account()->details();

echo $account['email'];
```
