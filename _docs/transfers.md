## Transfers

### Create a new transfer

```php
$transfer = Stripe::transfers()->create([
	'amount'    => 10,
	'currency'  => 'USD',
	'recipient' => 'rp_4EYxxX0LQWYDMs',
])->toArray();

echo $transfer['id'];
```

### Update a transfer

```php
$transfer = Stripe::transfers()->update([
	'id'          => 'tr_4EZer9REaUzJ76',
	'description' => 'Transfer to John Doe',
])->toArray();

echo $transfer['id'];
```

### Cancel a transfer

```php
$transfer = Stripe::transfers()->cancel([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();
```

### Retrieve all the existing transfers

```php
$transfers = Stripe::transfers()->all()->toArray();

foreach ($transfers['data'] as $transfer)
{
	var_dump($transfer['id']);
}
```

### Retrieve an existing transfer

```php
$transfers = Stripe::transfers()->find([
	'id' => 'tr_4EZer9REaUzJ76',
])->toArray();

echo $transfer['id'];
```
