#### Retrieve a refund

By default, you can see the 10 most recent refunds stored on a charge directly on the charge object, but you can also retrieve details about a specific refund stored on the charge.

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
    </tbody>
</table>

##### Usage

```php
$refund = $stripe->refunds()->find('ch_4ECWMVQp5SJKEx', 'txn_4IgdBGArAOeiQw');
```
