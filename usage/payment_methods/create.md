#### Create a payment method

Creates a Payment Method object. Read the [Stripe.js reference](https://stripe.com/docs/stripe-js/reference#stripe-create-payment-method) to learn how to create PaymentMethods via Stripe.js.

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
            <td>type</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The type of the PaymentMethod, one of: `card`.</td>
        </tr>
        <tr>
            <td>billing_details</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Billing information associated with the PaymentMethod that may be used or required by particular types of payment methods.</td>
        </tr>
        <tr>
            <td>card</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>If this is a card PaymentMethod, this array should contains the user’s card details.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a payment method object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentMethod = $stripe->paymentMethods()->create([
    'type' => 'card',
    'card' => [
        'number' => '4242424242424242',
        'exp_month' => 9,
        'exp_year' => 2020,
        'cvc' => '314'
    ],
]);

echo $paymentMethod['id'];
```
