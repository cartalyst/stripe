## Events

### Retrieve all the events

```
$response = Stripe::events()->all();
```

### Retrieve an event

```php
$response = Stripe::events()->find([
	'id' => 'evt_4ECnKrmXyNn8IM',
]);
```
