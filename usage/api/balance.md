## Balance

### Retrieve account balance

```php
$balance = Stripe::balance()->current();

echo $balance['pending']['amount'];
```

### Retrieve all the balance history

```php
$history = Stripe::balance()->all();

foreach ($history['data'] as $balance)
{
	var_dump($balance['id']);
}
```

### Retrieve a balance history

```php
$balance = Stripe::balance()->history([
	'id' => 'txn_4EI2Pu1gPR27yT',
]);

echo $balance['amount'];
```
