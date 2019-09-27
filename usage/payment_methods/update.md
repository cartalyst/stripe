#### Update a payment method

Updates a Payment Method object. A PaymentMethod must be attached a customer to be updated.

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
            <td>$paymentMethodId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The payment method unique identifier.</td>
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
            <td>billing_details</td>
            <td>true</td>
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
$paymentMethod = $stripe->paymentMethods()->update('pm_1FNPtF2eZvKYlo2Cc72xxtPl', [
    'metadata' => [
        'order_id' => '123456',
        ],
    ],
]);
```
