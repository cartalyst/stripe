#### Delete a coupon

You can delete coupons via the [coupon management](https://dashboard.stripe.com/coupons) page of the Stripe dashboard. However, deleting a coupon does not affect any customers who have already applied the coupon; it means that new customers can't redeem the coupon. You can also delete coupons via the API.

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
$coupon = $stripe->coupons()->delete('50-PERCENT-OFF');
```
