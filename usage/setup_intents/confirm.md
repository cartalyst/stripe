#### Confirm a setup intent

Confirm that your customer intends to set up the current or provided payment method. For example, you would confirm a Setup Intent when a customer hits the “Save” button on a payment method management page on your website.
If the selected payment method does not require any additional steps from the customer, the Setup Intent will transition to the `succeeded` status.

Otherwise, it will transition to the `requires_action` status and suggest additional actions via `next_action`. If setup fails, the Setup Intent will transition to the `requires_payment_method` status.

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
            <td>$setupIntentId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The setup intent unique identifier.</td>
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
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the payment method (a PaymentMethod, Card, BankAccount, or saved Source object) to attach to this Setup Intent.</td>
        </tr>
        <tr>
            <td>return_url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL to redirect your customer back to after they authenticate on the payment method’s app or site.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$setupIntent = $stripe->setupIntents()->confirm('seti_123456789', [
    'payment_method' => 'pm_card_visa',
]);
```
