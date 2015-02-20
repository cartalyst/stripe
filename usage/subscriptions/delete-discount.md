#### Delete a subscription discount

Removes the currently applied discount on a subscription.

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
            <td>$customerId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The customer unique identifier.</td>
        </tr>
        <tr>
            <td>$subscriptionId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The subscription unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$customer = $stripe->subscriptions()->deleteDiscount('cus_4EBumIjyaKooft', 'sub_4ETjGeEPC5ai9J');
```
