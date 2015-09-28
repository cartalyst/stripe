#### Retrieve an order

Retrieves the details of an existing order. Supply the unique order ID from either an order creation request or the order list, and Stripe will return the corresponding order information.

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
    </tbody>
</table>

##### Usage

```php
$order = $stripe->orders()->find('or_16nYXbJvzVWl1WTe7t5ODS8z');

echo $order['status'];
```
