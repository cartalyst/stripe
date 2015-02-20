#### Update a plan

Updates the name of a plan. Other plan details (price, interval, etc.) are, by design, not editable.

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
            <td>$planId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The plan unique identifier.</td>
        </tr>
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
            <td>name</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The name of the plan.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>statement_description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which will be displayed on the customer's bank statement.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$plan = $stripe->plans()->update('monthly', [
    'name' => 'Monthly Subscription',
]);

echo $plan['name'];
```
