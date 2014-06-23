## Recipients

### Create a new recipient

```php
$recipient = Stripe::recipients()->create([
	'name' => 'John Doe',
	'type' => 'individual',
])->toArray();
```

### Update a recipient

```php
$recipient = Stripe::recipients()->update([
	'id'   => 'rp_4EYRyEYthf2Doc',
	'name' => 'John Doe Inc.',
])->toArray();
```

### Delete a recipient

```php
$recipient = Stripe::recipients()->delete([
	'id' => 'rp_4EYRyEYthf2Doc',
])->toArray();
```

### Retrieve all the recipients

```php
$recipients = Stripe::recipients()->all()->toArray();

foreach ($recipients['data'] as $recipient)
{
	var_dump($recipient['id']);
}
```

### Retrieve a recipient

```php
$recipient = Stripe::recipients()->find([
	'id' => '50-PERCENT-OFF',
])->toArray();

echo $recipient['id'];
```
