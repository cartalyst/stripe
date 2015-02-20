#### Create a new invoice item

Adds an arbitrary charge or credit to the customer's upcoming invoice.

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
            <td>$customerId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The customer unique identifier.</td>
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
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>subscription</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The subscription unique identifier to add this invoice item to</td>
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
$invoiceItem = $stripe->invoiceItems()->create('cus_4EBumIjyaKooft', [
    'amount'   => 50.00,
    'currency' => 'USD',
]);

echo $invoiceItem['id'];
```
