#### Retrieve an application fee

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
    </tbody>
</table>

##### Usage

```php
$fee = $stripe->applicationFees()->find('fee_4EUveQeJwxqxD4');

echo $fee['id'];
```
