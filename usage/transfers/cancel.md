#### Cancel a transfer

Cancels a transfer that has previously been created. Funds will be refunded to your available balance, and the fees you were originally charged on the transfer will be refunded. You may not cancel transfers that have already been paid out, or automatic Stripe transfers.

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
$transfer = $stripe->transfers()->cancel('tr_4EZer9REaUzJ76');
```
