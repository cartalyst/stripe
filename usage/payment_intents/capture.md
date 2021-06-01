#### Capture a payment intent

Capture the funds of an existing uncaptured Payment Intent when its status is `requires_capture`.

Uncaptured Payment Intents will be canceled exactly seven days after they are created.

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
            <td>amount_to_capture</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>The amount to capture from the Payment Intent, which must be less than or equal to the original amount.</td>
        </tr>
        <tr>
            <td>amount_to_capture</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>The amount to capture from the Payment Intent, which must be less than or equal to the original amount.</td>
        </tr>
        <tr>
            <td>application_fee_amount</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>The amount of the application fee (if any) that will be applied to the payment and transferred to the application owner’s Stripe account.</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>For non-card charges, you can use this value as the complete description that appears on your customers’ statements.</td>
        </tr>
        <tr>
            <td>statement_descriptor_suffix</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Provides information about a card payment that customers see on their statements.</td>
        </tr>
        <tr>
            <td>transfer_data</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>The parameters used to automatically create a Transfer when the payment is captured.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentIntent = $stripe->paymentIntents()->capture('pi_1FFOKyEind3TueVhoddAahvY');
```
