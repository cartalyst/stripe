#### Retrieve a reversal

By default, you can see the 10 most recent reversals stored directly on the transfer object, but you can also retrieve details about a specific reversal stored on the transfer.

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
    </tbody>
</table>

##### Usage

```php
$reversal = $stripe->transferReversals()->find('tr_15nBIqJvzVWl1WTebSIGDfRv', 'trr_15nBIqJvzVWl1WTeMR8Spwxe');

echo $reversal['description'];
```
