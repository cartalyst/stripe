#### Update a refund

Updates the specified refund by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

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
            <td>$chargeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The charge unique identifier.</td>
        </tr>
        <tr>
            <td>$refundId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The refund unique identifier.</td>
        </tr>
        <tr>
            <td>$parameters</td>
            <td>false</td>
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
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a refund object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$refund = $stripe->refunds()->update('ch_4ECWMVQp5SJKEx', 'txn_4IgdBGArAOeiQw', [
    'metadata' => [
        'reason'      => 'Customer requested for the refund.',
        'refunded_by' => 'John Doe',
    ],
]);
```
