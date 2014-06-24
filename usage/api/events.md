## Events

### Retrieve all the events

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.
type           | false    | string | null    | A string containing a specific event name, or group of events using * as a wildcard.

```php
$events = Stripe::events()->all()->toArray();

foreach ($events['data'] as $event)
{
	var_dump($event);
}
```

### Retrieve an event

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The event unique identifier.

```php
$event = Stripe::events()->find([
	'id' => 'evt_4ECnKrmXyNn8IM',
])->toArray();

echo $event['type'];
```
