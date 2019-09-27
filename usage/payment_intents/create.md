#### Create a payment intent

Creates a Payment Intent object.

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
            <td>$parameters</td>
            <td>true</td>
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
            <td>currency</td>
            <td>false</td>
            <td>string</td>
            <td>false</td>
            <td>Three-letter ISO currency code, in lowercase. </td>
        </tr>
        <tr>
            <td>application_fee_amount</td>
            <td>false</td>
            <td>integer</td>
            <td>false</td>
            <td>The amount of the application fee (if any) that will be applied to the payment and transferred to the application owner’s Stripe account.</td>
        </tr>
        <tr>
            <td>capture_method</td>
            <td>false</td>
            <td>string</td>
            <td>false</td>
            <td>One of `automatic` (default) or `manual`. When the capture method is `automatic`, Stripe automatically captures funds when the customer authorizes the payment.</td>
        </tr>
        <tr>
            <td>confirm</td>
            <td>false</td>
            <td>boolean</td>
            <td>false</td>
            <td>Set to `true` to attempt to confirm this Payment Intent immediately.</td>
        </tr>
        <tr>
            <td>confirmation_method</td>
            <td>false</td>
            <td>string</td>
            <td>false</td>
            <td>One of `automatic` (default) or `manual`. When the confirmation method is `automatic`, a Payment Intent can be confirmed using a publishable key. After `next_action`s are handled, no additional confirmation is required to complete the payment.</td>
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
            <td>off_session</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Set to `true` to indicate that the customer is not in your checkout flow during this payment attempt, and therefore is unable to authenticate.</td>
        </tr>
        <tr>
            <td>on_behalf_of</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The Stripe account ID for which this Payment Intent is created.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the Payment Method (a Payment Method, Card, BankAccount, or saved Source object) to attach to this Payment Intent.</td>
        </tr>
        <tr>
            <td>payment_method_options</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Payment-method-specific configuration for this Payment Intent.</td>
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
            <td>return_url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL to redirect your customer back to after they authenticate or cancel their payment on the payment method’s app or site. If you’d prefer to redirect to a mobile application, you can alternatively supply an application URI scheme. This parameter can only be used with `confirm` is `true`.</td>
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
$paymentIntent = $stripe->paymentIntents()->create([
    'amount' => 2000,
    'currency' => 'usd',
    'payment_method_types' => [
        'card',
    ],
]);

echo $paymentIntent['id'];
```
