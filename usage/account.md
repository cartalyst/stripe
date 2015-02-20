### Account

This is an object representing your Stripe account. You can retrieve it to see properties on the account like its current e-mail address or if the account is enabled yet to make live charges.

Retrieve information about your Stripe account.

##### Example

```php
$account = $stripe->account()->details();

echo $account['email'];
```
