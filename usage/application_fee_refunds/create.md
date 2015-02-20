#### Create an application fee refund

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
            <td>The application fee id unique identifier.</td>
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
            <td>amount</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount representing how much of this fee to refund.</td>
        </tr>
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
$fee = $stripe->applicationFeeRefunds()->create('fee_4EUveQeJwxqxD4', [
    'amount' => 10.30,
]);
```
