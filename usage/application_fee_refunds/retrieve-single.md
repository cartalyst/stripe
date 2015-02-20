#### Retrieve an application fee refund

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
    </tbody>
</table>

##### Usage

```php
$fee = $stripe->applicationFeeRefunds()->find('fee_4EUveQeJwxqxD4', 'fr_5jSKUTcb2ZkbRA');

echo $fee['id'];
```
