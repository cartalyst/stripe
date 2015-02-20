#### Retrieve an invoice

Retrieves the invoice with the given ID.

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
            <td>$invoiceId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The invoice unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$invoice = $stripe->invoices()->find('in_4EgP02zb8qxsLq');

echo $invoice['paid'];
```
