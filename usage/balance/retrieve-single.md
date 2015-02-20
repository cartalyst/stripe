#### Retrieve a balance history

Retrieves the balance transaction with the given ID.

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
            <td>$transactionId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The transaction unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$balance = $stripe->balance()->find('txn_4EI2Pu1gPR27yT');

echo $balance['amount'];
```
