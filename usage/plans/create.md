#### Create a plan

You can create plans easily via the [plan management](https://dashboard.stripe.com/plans) page of the Stripe dashboard. Plan creation is also accessible via the API if you need to create plans on the fly.

##### Arguments

<table>
    <thead>
        <th>Key</th>
        <th>Required</th>
        <th>Type</th>
        <th>Default</th>
        <th>Description</th>
    </thead>
    <tbody>
        <tr>
            <td>$parameters</td>
            <td>true</td>
            <td>array</td>
            <td>null</td>
            <td>Please refer to the list below for a valid list of keys that can be passed on this array.</td>
        </tr>
    </tbody>
</table>

###### $parameters

<table>
    <thead>
        <th>Key</th>
        <th>Required</th>
        <th>Type</th>
        <th>Default</th>
        <th>Description</th>
    </thead>
    <tbody>
        <tr>
            <td>id</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The plan unique identifier.</td>
        </tr>
        <tr>
            <td>amount</td>
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount for the transaction.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>interval</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>Specifies billing frequency. Either week, month or year.</td>
        </tr>
        <tr>
            <td>interval_count</td>
            <td>false</td>
            <td>integer</td>
            <td>1</td>
            <td>The number of intervals between each subscription billing.</td>
        </tr>
        <tr>
            <td>name</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The name of the plan.</td>
        </tr>
        <tr>
            <td>trial_period_days</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Specifies a trial period in (an integer number of) days.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which will be displayed on the customer's bank statement.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$plan = $stripe->plans()->create([
    'id'                   => 'monthly',
    'name'                 => 'Monthly (30$)',
    'amount'               => 30.00,
    'currency'             => 'USD',
    'interval'             => 'month',
    'statement_descriptor' => 'Monthly Subscription to Foo Bar Inc.',
]);

echo $plan['id'];
```
