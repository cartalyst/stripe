#### Create an invoice

If you need to invoice your customer outside the regular billing cycle, you can create an invoice that pulls in all pending invoice items, including prorations. The customer's billing cycle and regular subscription won't be affected.

Once you create the invoice, it'll be picked up and paid automatically, though you can choose to [pay it right away](#pay-an-existing-invoice).

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
            <td>application_fee</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>An application fee to add on to this invoice.</td>
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
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Extra information about a charge for the customer’s credit card statement.</td>
        </tr>
        <tr>
            <td>subscription</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The subscription unique identifier to invoice.</td>
        </tr>
        <tr>
            <td>tax_percent</td>
            <td>false</td>
            <td>decimal</td>
            <td>null</td>
            <td>The percent tax rate applied to the invoice, represented as a decimal number</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$invoice = $stripe->invoices()->create('cus_4EBumIjyaKooft');
```
