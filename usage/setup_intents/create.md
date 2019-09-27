#### Create a setup intent

Creates a Setup Intent object.

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
            <td>confirm</td>
            <td>false</td>
            <td>boolean</td>
            <td>false</td>
            <td>Set to `true` to attempt to confirm this Setup Intent immediately.</td>
        </tr>
        <tr>
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the Customer this Setup Intent belongs to, if one exists.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string attached to the Setup Intent. Often useful for displaying to users.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a Setup Intent object.</td>
        </tr>
        <tr>
            <td>on_behalf_of</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The Stripe account ID for which this Setup Intent is created.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the Payment Method (a Payment Method, Card, BankAccount, or saved Source object) to attach to this Setup Intent.</td>
        </tr>
        <tr>
            <td>payment_method_options</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Payment-method-specific configuration for this SetupIntent.</td>
        </tr>
        <tr>
            <td>payment_method_types</td>
            <td>false</td>
            <td>array</td>
            <td>["card"]</td>
            <td>The list of Payment Method types that this Setup Intent is allowed to set up. If this is not provided, defaults to `["card"]`. Valid Payment Method types include: `card`.</td>
        </tr>
        <tr>
            <td>return_url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL to redirect your customer back to after they authenticate or cancel their payment on the payment method’s app or site. If you’d prefer to redirect to a mobile application, you can alternatively supply an application URI scheme. This parameter can only be used with `confirm` is `true`.</td>
        </tr>
        <tr>
            <td>usage</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Indicates how the payment method is intended to be used in the future. If not provided, this value defaults to off_session. Possible values: `on_session`, `off_session`.</td>
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
