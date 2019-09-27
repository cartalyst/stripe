#### Confirm a payment intent

Confirm that your customer intends to pay with current or provided payment method. Upon confirmation, the Payment Intent will attempt to initiate a payment.

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
            <td>off_session</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Set to `true` to indicate that the customer is not in your checkout flow during this payment attempt, and therefore is unable to authenticate.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the payment method (a PaymentMethod, Card, BankAccount, or saved Source object) to attach to this Payment Intent.</td>
        </tr>
        <tr>
            <td>payment_method_options</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Payment-method-specific configuration for this Payment Intent.</td>
        </tr>
        <tr>
            <td>payment_method_types</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>The list of payment method types (e.g. card) that this Payment Intent is allowed to use.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Email address that the receipt for the resulting payment will be sent to.</td>
        </tr>
        <tr>
            <td>return_url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL to redirect your customer back to after they authenticate or cancel their payment on the payment method’s app or site.</td>
        </tr>
        <tr>
            <td>save_payment_method</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>If the Payment Intent has a `payment_method` and a `customer  or if you’re attaching a payment method to the Payment Intent in this request, you can pass the `save_payment_method` as `true` to save the payment method to the customer.</td>
        </tr>
        <tr>
            <td>setup_future_usage</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Indicates that you intend to make future payments with this PaymentIntent’s payment method.</td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Shipping information for this PaymentIntent.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentIntent = $stripe->paymentIntents()->confirm('pi_1FFOKyEind3TueVhoddAahvY', [
    'payment_method' => 'pm_card_visa',
]);
```
