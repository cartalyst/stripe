#### Create an order

Creates a new order object.

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
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of an existing customer that will be charged in this request.</td>
        </tr>
        <tr>
            <td>email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The email address of the customer placing the order.</td>
        </tr>
        <tr>
            <td>items</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>List of items constituting the order.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Shipping address for the order. Required if any of the SKUs are for products that have `shippable` set to true.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$order = $stripe->orders()->create([
    'currency' => 'usd',
    'items' => [
        [
            'type'   => 'sku',
            'parent' => 't-shirt-small-red',
        ],
    ],
    'shipping' => [
        'name'    => 'Jenny Rosen',
        'address' => [
            'line1'       => '1234 Main street',
            'city'        => 'Anytown',
            'country'     => 'US',
            'postal_code' => '123456',
        ],
    ],
    'email' => 'jenny@ros.en'
]);

echo $order['id'];
```
