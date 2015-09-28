#### Retrieve all orders

Returns a list of your orders. The orders are returned sorted by creation date, with the most recently created orders appearing first.

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
            <td>ending_before</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>ids</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return orders with the given IDs.</td>
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
        <tr>
            <td>status</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return orders that have the given status. One of `created`, `paid`, `fulfilled`, or `refunded`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$orders = $stripe->orders()->all();

foreach ($orders['data'] as $order) {
    var_dump($order['id']);
}
```
