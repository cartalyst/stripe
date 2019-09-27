#### Update a charge

Updates the specified charge by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

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
            <td>$chargeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The charge unique identifier.</td>
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
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of an existing customer that will be associated with this request.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a charge object.</td>
        </tr>
        <tr>
            <td>fraud_details</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a charge object giving information about its riskiness.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a charge object.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>This is the email address that the receipt for this charge will be sent to.</td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Shipping information for the charge. Helps prevent fraud on charges for physical goods.</td>
        </tr>
        <tr>
            <td>transfer_group</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A string that identifies this transaction as part of a group.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$charge = $stripe->charges()->update('ch_4ECWMVQp5SJKEx', [
    'description' => 'Payment to foo bar',
]);
```
