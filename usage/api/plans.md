## Plans

### Create a new plan

Key                   | Required | Type   | Default | Description
--------------------- | -------- | ------ | ------- | --------------------------
id                    | true     | string | null    | The plan unique identifier.
amount                | true     | number | null    | A positive amount for the transaction.
currency              | true     | string | null    | 3-letter ISO code for currency.
interval              | true     | string | null    | Specifies billing frequency. Either week, month or year.
interval_count        | false    | int    | 1       | The number of intervals between each subscription billing.
name                  | true     | string | null    | The name of the plan.
trial_period_days     | false    | int    | null    | Specifies a trial period in (an integer number of) days.
metadata              | false    | array  | []      | A set of key/value pairs that you can attach to a transfer object
statement_description | false    | string | null    | An arbitrary string which will be displayed on the customer's bank statement.

```php
$plan = Stripe::plans()->create([
	'id'                    => 'monthly',
	'name'                  => 'Monthly (30$)',
	'amount'                => 30.00,
	'currency'              => 'USD',
	'interval'              => 'month',
	'statement_description' => 'Monthly Subscription to Foo Bar Inc.',
]);

echo $plan['id'];
```

### Delete a plan

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The plan unique identifier.

```php
$plan = Stripe::plans()->destroy([
	'id' => 'monthly',
]);
```

### Update a plan

Key                   | Required | Type   | Default | Description
--------------------- | -------- | ------ | ------- | --------------------------
id                    | true     | string | null    | The plan unique identifier.
name                  | false    | string | null    | The name of the plan.
metadata              | false    | array  | []      | A set of key/value pairs that you can attach to a transfer object
statement_description | false    | string | null    | An arbitrary string which will be displayed on the customer's bank statement.

```php
$plan = Stripe::plans()->update([
	'id'   => 'monthly',
	'name' => 'Monthly Subscription',
]);

echo $plan['name'];
```

### Retrieve all the existing plans

Key            | Required | Type   | Default | Description
-------------- | -------- | ------ | ------- | ---------------------------------
ending_before  | false    | string | null    | A cursor to be used in pagination.
limit          | false    | int    | 10      | A limit on the number of objects to be returned.
starting_after | false    | string | null    | A cursor to be used in pagination.

```php
$plans = Stripe::plans()->all();

foreach ($plans['data'] as $plan)
{
	var_dump($plan['id']);
}
```

### Retrieve an existing plan

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The plan unique identifier.

```php
$plan = Stripe::plans()->find([
	'id' => 'monthly',
]);

echo $plan['name'];
```
