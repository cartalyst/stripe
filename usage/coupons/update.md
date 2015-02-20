#### Update a coupon

Updates the specified coupon by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

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
            <td>$couponId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The coupon unique identifier.</td>
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
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a coupon object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$coupon = $stripe->coupons()->update('50-PERCENT-OFF', [
    'metadata' => [
        'foo' => 'Bar',
    ],
]);
```
