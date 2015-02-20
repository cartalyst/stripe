#### Retrieve a coupon

Retrieves the coupon with the given ID.

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
    </tbody>
</table>

##### Usage

```php
$coupon = $stripe->coupons()->find('50-PERCENT-OFF');

echo $coupon['percent_off'];
```
