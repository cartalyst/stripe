#### Update a subscription

Updates an existing subscription on a customer to match the specified parameters. When changing plans or quantities, we will optionally prorate the price we charge next month to make up for any price changes.

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
            <td>plan</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The plan unique identifier.</td>
        </tr>
        <tr>
            <td>coupon</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The coupon unique identifier.</td>
        </tr>
        <tr>
            <td>prorate</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>The coupon unique identifier.</td>
        </tr>
        <tr>
            <td>trial_end</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>Flag telling Stripe whether to prorate switching plans during a billing cycle.</td>
        </tr>
        <tr>
            <td>source</td>
            <td>false</td>
            <td>string | array</td>
            <td>null</td>
            <td>The source can either be a token or a dictionary containing the source details.</td>
        </tr>
        <tr>
            <td>quantity</td>
            <td>false</td>
            <td>integer</td>
            <td>1</td>
            <td>The quantity you'd like to apply to the subscription you're creating.</td>
        </tr>
        <tr>
            <td>application_fee_percent</td>
            <td>false</td>
            <td>decimal</td>
            <td>null</td>
            <td>A positive decimal (with at most two decimal places) between 1 and 100.</td>
        </tr>
        <tr>
            <td>tax_percent</td>
            <td>false</td>
            <td>decimal</td>
            <td>null</td>
            <td>A positive decimal (with at most two decimal places) between 1 and 100.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a subscription object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$subscription = $stripe->subscriptions()->update('cus_4EBumIjyaKooft', 'sub_4ETjGeEPC5ai9J', [
    'plan' => 'monthly',
]);
```
