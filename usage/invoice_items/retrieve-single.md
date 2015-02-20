#### Retrieve an invoice item

Retrieves the invoice item with the given ID.

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
            <td>$invoiceItemId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The invoice item unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$invoiceItem = $stripe->invoiceItems()->find('ii_4Egr3tUtHjVEnm');

echo $invoiceItem['amount'];
```
