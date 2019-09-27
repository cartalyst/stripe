#### Update a payment intent

Updates properties on a Payment Intent without confirming.

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
            <td>amount</td>
            <td>required</td>
            <td>boolean</td>
            <td>required</td>
            <td>A positive integer representing how much to charge in the smallest currency unit (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a zero-decimal currency).</td>
        </tr>
        <tr>
            <td>application_fee_amount</td>
            <td>false</td>
            <td>integer</td>
            <td>false</td>
            <td>The amount of the application fee (if any) that will be applied to the payment and transferred to the application owner’s Stripe account.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>false</td>
            <td>string</td>
            <td>false</td>
            <td>Three-letter ISO currency code, in lowercase. </td>
        </tr>
        <tr>
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the Customer this Payment Intent belongs to, if one exists.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string attached to the Payment Intent. Often useful for displaying to users.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a Payment Intent object.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the Payment Method (a Payment Method, Card, BankAccount, or saved Source object) to attach to this Payment Intent.</td>
        </tr>
        <tr>
            <td>payment_method_types</td>
            <td>false</td>
            <td>array</td>
            <td>["card"]</td>
            <td>The list of Payment Method types that this Payment Intent is allowed to set up. If this is not provided, defaults to `["card"]`. Valid Payment Method types include: `card`.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Email address that the receipt for the resulting payment will be sent to.</td>
        </tr>
        <tr>
            <td>save_payment_method</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>If the Payment Intent has a `payment_method` and a `customer` or if you’re attaching a payment method to the Payment Intent in this request, you can pass `save_payment_method` as `true` to save the payment method to the customer. </td>
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
            <td>The parameters used to automatically create a Transfer when the payment succeeds.</td>
        </tr>
        <tr>
            <td>transfer_group</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A string that identifies the resulting payment as part of a group.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentIntent = $stripe->paymentIntents()->update('pi_1FFOKyEind3TueVhoddAahvY', [
    'metadata' => [
        'order_id' => '123456',
    ],
]);

echo $paymentIntent['id'];
```
