#### Updates an order

Updates the specific order by setting the values of the parameters passed. Any parameters not provided will be left unchanged. This request accepts only the `metadata`, and `status` as arguments.

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
            <td>$orderId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The order unique identifier.</td>
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
            <td>coupon</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A coupon code that represents a discount to be applied to this order. Must be one-time duration and in same currency as the order.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>selected_shipping_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The shipping method to select for fulfilling this order. If specified, must be one of the `id`s of a shipping method in the `shipping_methods` array. If specified, will overwrite the existing selected shipping method, updating `items` as necessary.</td>
        </tr>
        <tr>
            <td>status</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Current order status. One of `created`, `paid`, `canceled`, `fulfilled`, or `returned`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$order = $stripe->orders()->update('or_16nYXbJvzVWl1WTe7t5ODS8z', [
    'metadata' => [
        'foo' => 'Bar',
    ],
]);

echo $order['status'];
```
