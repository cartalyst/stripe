### Plans

A subscription plan contains the pricing information for different products and feature levels on your site. For example, you might have a €10/month plan for basic features and a different €20/month plan for premium features.

#### Create a new plan

You can create plans easily via the [plan management](https://dashboard.stripe.com/plans) page of the Stripe dashboard. Plan creation is also accessible via the API if you need to create plans on the fly.

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

#### Delete a plan

You can delete plans via the [plan management](https://dashboard.stripe.com/plans) page of the Stripe dashboard. However, deleting a plan does not affect any current subscribers to the plan; it merely means that new subscribers can't be added to that plan. You can also delete plans via the API.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The plan unique identifier.

```php
$plan = Stripe::plans()->destroy([
	'id' => 'monthly',
]);
```

#### Update a plan

Updates the name of a plan. Other plan details (price, interval, etc.) are, by design, not editable.

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

#### Retrieve all the existing plans

Returns a list of your plans.

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

#### Retrieve an existing plan

Retrieves the plan with the given ID.

Key | Required | Type   | Default | Description
--- | -------- | ------ | ------- | --------------------------------------------
id  | true     | string | null    | The plan unique identifier.

```php
$plan = Stripe::plans()->find([
	'id' => 'monthly',
]);

echo $plan['name'];
```
