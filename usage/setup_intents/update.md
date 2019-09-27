#### Update a setup intent

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
            <td>customer</td>
            <td>true</td>
            <td>array</td>
            <td>null</td>
            <td>ID of the Customer this Setup Intent belongs to, if one exists.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string attached to the object. Often useful for displaying to users.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a setup intent object.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the payment method (a PaymentMethod, Card, BankAccount, or saved Source object) to attach to this Setup Intent.</td>
        </tr>
        <tr>
            <td>payment_method_types</td>
            <td>false</td>
            <td>array</td>
            <td>["card"</td>
            <td>The list of payment method types (e.g. card) that this Setup Intent is allowed to set up. If this is not provided, defaults to ["card"].</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$setupIntent = $stripe->setupIntents()->update('seti_123456789', [
    'metadata' => [
        'order_id' => '123456',
    ],
]);
```
