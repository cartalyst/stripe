#### Cancel a payment intent

A Payment Intent object can be canceled when it is in one of these statuses: `requires_payment_method`, `requires_capture`, `requires_confirmation`, `requires_action`.

Once canceled, no additional charges will be made by the Payment Intent and any operations on the Payment Intent will fail with an error.

For Payment Intents with a `status` of `requires_capture`, the remaining `amount_capturable` will automatically be refunded.

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
            <td>$paymentIntentId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The payment intent unique identifier.</td>
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
            <td>cancellation_reason</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Reason for canceling this Payment Intent. Possible values are `duplicate`, `fraudulent`, `requested_by_customer`, or `abandoned`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentIntent = $stripe->paymentIntents()->cancel('pi_1FFOKyEind3TueVhoddAahvY');
```
