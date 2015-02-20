#### Pay an invoice

Stripe automatically creates and then attempts to pay invoices for customers on subscriptions. We'll also retry unpaid invoices according to your [retry settings](https://dashboard.stripe.com/account/recurring). However, if you'd like to attempt to collect payment on an invoice out of the normal retry schedule or for some other reason, you can do so.

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
$invoice = $stripe->invoices()->pay('in_4EgP02zb8qxsLq');
```
