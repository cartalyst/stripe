#### Update a reversal

Updates the specified reversal by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

This request only accepts metadata and description as arguments.

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
            <td>$transferId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The transfer unique identifier.</td>
        </tr>
        <tr>
            <td>$transferReversalId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The transfer reversal unique identifier.</td>
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
            <td>A set of key/value pairs that you can attach to a reversal object.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a reversal object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$reversal = $stripe->transferReversals()->update('tr_15nBIqJvzVWl1WTebSIGDfRv', 'trr_15nBIqJvzVWl1WTeMR8Spwxe', [
    'description' => 'Reversed the transfer.',
]);

echo $reversal['description'];
```
