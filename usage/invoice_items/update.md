#### Update an invoice item

Updates the amount or description of an invoice item on an upcoming invoice. Updating an invoice item is only possible before the invoice it's attached to is closed.

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
        <tr>
            <td>$parameters</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Please refer to the list below for a valid list of keys that can be passed on this array.</td>
        </tr>
    </tbody>
</table>

###### $parameters

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
            <td>amount</td>
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount for the transaction.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a invoice object.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a invoice object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$invoiceItem = $stripe->invoiceItems()->update('ii_4Egr3tUtHjVEnm', [
    'description' => 'Candy',
    'metadata'    => [
        'foo' => 'Bar',
    ],
]);
```
