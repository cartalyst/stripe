### Balance

This is an object representing your Stripe balance. You can retrieve it to see the balance currently on your Stripe account.

You can also retrieve a list of the balance history, which contains a full list of transactions that have ever contributed to the balance (charges, refunds, transfers, and so on).

#### Retrieve account balance

```php
$balance = Stripe::balance()->current();

echo $balance['pending']['amount'];
```

#### Retrieve all the balance history

```php
$history = Stripe::balance()->all();

foreach ($history['data'] as $balance)
{
	var_dump($balance['id']);
}
```

#### Retrieve a balance history

```php
$balance = Stripe::balance()->history([
	'id' => 'txn_4EI2Pu1gPR27yT',
]);

echo $balance['amount'];
```
