#### Create a customer

Creates a new customer object.

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
            <td>account_balance</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount that is the starting account balance for your customer.</td>
        </tr>
        <tr>
            <td>coupon</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Coupon identifier that applies a discount on all recurring charges.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string that you can attach to a customer object.</td>
        </tr>
        <tr>
            <td>email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Customer’s email address.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a customer object.</td>
        </tr>
        <tr>
            <td>plan</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Plan for the customer.</td>
        </tr>
        <tr>
            <td>quantity</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>Quantity you'd like to apply to the subscription you're creating.</td>
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
    </tbody>
</table>

##### Usage

```php
$customer = $stripe->customers()->create([
    'email' => 'john@doe.com',
]);

echo $customer['id'];
```
