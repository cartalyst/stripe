#### Delete an invoice item

Removes an invoice item from the upcoming invoice. Removing an invoice item is only possible before the invoice it's attached to is closed.

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
$stripe->invoiceItems()->delete('ii_4Egr3tUtHjVEnm');
```
