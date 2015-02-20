#### Update a dispute

When you get a dispute, contacting your customer is always the best first step. If that doesn't work, you can submit evidence in order to help us resolve the dispute in your favor. You can do this in your [dashboard](https://dashboard.stripe.com/#disputes), but if you prefer, you can use the API to submit evidence programmatically.

Depending on your dispute type, different evidence fields will give you a better chance of winning your dispute. You may want to consult the Stripe [guide to dispute types](https://stripe.com/help/dispute-types) to help you figure out which evidence fields to provide.

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
            <td>$chargeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The charge unique identifier.</td>
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
            <td>evidence</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An evidence that you can attach to a dispute object.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a charge object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$dispute = $stripe->disputes()->update('ch_4ECWMVQp5SJKEx', [
    'evidence' => 'Customer agreed to drop the dispute.',
]);
```
