#### Retrieve account balance

Retrieves the current account balance, based on the API key that was used to make the request.

##### Usage

```php
$balance = $stripe->balance()->current();

echo $balance['pending']['amount'];
```
