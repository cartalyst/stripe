#### Update an application fee refund

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
            <td>$applicationFeeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The application fee unique identifier.</td>
        </tr>
        <tr>
            <td>$refundId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The application fee refund unique identifier.</td>
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
            <td>A set of key/value pairs that you can attach to a charge object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$fee = $stripe->applicationFeeRefunds()->update('fee_4EUveQeJwxqxD4', 'fr_5jSKUTcb2ZkbRA', [
    'metadata' => [
        'foo' => 'bar'
    ],
]);

echo $fee['id'];
```
