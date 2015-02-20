#### Retrieve a transfer

Retrieves the details of an existing transfer. Supply the unique transfer ID from either a transfer creation request or the transfer list, and Stripe will return the corresponding transfer information.

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
    </tbody>
</table>

##### Usage

```php
$transfers = $stripe->transfers()->find('tr_4EZer9REaUzJ76');

echo $transfer['id'];
```
