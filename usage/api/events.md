### Events

Events are our way of letting you know about something interesting that has just happened in your account. When an interesting event occurs, we create a new event object. For example, when a charge succeeds we create a charge.succeeded event; or, when an invoice can't be paid we create an invoice.payment_failed event. Note that many API requests may cause multiple events to be created. For example, if you create a new subscription for a customer, you will receive both a customer.subscription.created event and a charge.succeeded event.

#### Retrieve all the events

##### Arguments

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
created        | false    | string | null    | A filter on the list based on the object created field.
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.
type           | false    | string | null    | A string containing a specific event name, or group of events using * as a wildcard.

```php
$events = Stripe::events()->all();

foreach ($events['data'] as $event)
{
	var_dump($event);
}
```

#### Retrieve an event

##### Arguments

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The event unique identifier.

```php
$event = Stripe::events()->find([
	'id' => 'evt_4ECnKrmXyNn8IM',
]);

echo $event['type'];
```
