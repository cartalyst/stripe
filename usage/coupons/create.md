#### Create a coupon

You can create coupons easily via the [coupon management](https://dashboard.stripe.com/coupons) page of the Stripe dashboard. Coupon creation is also accessible via the API if you need to create coupons on the fly.

A coupon has either a `percent_off` or an `amount_off` and `currency`. If you set an `amount_off`, that amount will be subtracted from any invoice's subtotal. For example, an invoice with a subtotal of $10 will have a final total of $0 if a coupon with an `amount_off` of 2000 is applied to it and an invoice with a subtotal of $30 will have a final total of $10 if a coupon with an `amount_off` of 2000 is applied to it.

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
            <td>id</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The coupon unique identifier, if not provided a random string will be generated.</td>
        </tr>
        <tr>
            <td>duration</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>Specifies how long the discount will be in effect. Can be `forever`, `once` or `repeating`.</td>
        </tr>
        <tr>
            <td>amount_off</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount representing the amount to subtract from an invoice total (required if percent_off is not passed).</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>duration_in_months</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>If duration is repeating, a positive integer that specifies the number of months the discount will be in effect.</td>
        </tr>
        <tr>
            <td>max_redemptions</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>A positive integer specifying the number of times the coupon can be redeemed before it’s no longer valid.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a coupon object.</td>
        </tr>
        <tr>
            <td>percent_off</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>A positive integer between 1 and 100 that represents the discount the coupon will apply (required if amount_off is not passed).</td>
        </tr>
        <tr>
            <td>redeem_by</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>Unix timestamp specifying the last time at which the coupon can be redeemed.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$coupon = $stripe->coupons()->create([
    'id'          => '50-PERCENT-OFF',
    'duration'    => 'forever',
    'percent_off' => 50,
]);

echo $coupon['id'];
```
