#### Create a subscription

Creates a new subscription on an existing customer.

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
            <td>plan</td>
            <td>true</td>
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
            <td>trial_end</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>UTC integer timestamp representing the end of the trial period the customer will get before being charged for the first time.</td>
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
$subscription = $stripe->subscriptions()->create('cus_4EBumIjyaKooft', [
    'plan' => 'monthly',
]);

echo $subscription['id'];
```
