#### Update an invoice

Until an invoice is paid, it is marked as open (closed=false). If you'd like to stop Stripe from automatically attempting payment on an invoice or would simply like to close the invoice out as no longer owed by the customer, you can update the closed parameter.

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
            <td>closed</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Boolean representing whether an invoice is closed or not. To close an invoice, pass true.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a invoice object.</td>
        </tr>
        <tr>
            <td>forgiven</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Boolean representing whether an invoice is forgiven or not.</td>
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
$invoice = $stripe->invoices()->update('in_4EgP02zb8qxsLq', [
    'closed' => true,
]);
```
