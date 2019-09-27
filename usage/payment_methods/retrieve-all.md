#### Retrieve all payment methods

Returns a list of Payment Methods for a given Customer.

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
            <td>required</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of the customer whose PaymentMethods will be retrieved.</td>
        </tr>
        <tr>
            <td>type</td>
            <td>required</td>
            <td>string</td>
            <td>null</td>
            <td>A required filter on the list, based on the object type field.</td>
        </tr>
        <tr>
            <td>ending_before</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>limit</td>
            <td>false</td>
            <td>integer</td>
            <td>10</td>
            <td>A limit on the number of objects to be returned.</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentMethods = $stripe->paymentMethods()->all([
    'type' => 'card',
    'customer' => 'cus_FtAnrEozrF5NDy',
]);

foreach ($paymentMethods['data'] as $paymentMethod) {
    var_dump($paymentMethod['id']);
}
```
