#### Capture a charge

Capture the payment of an existing, uncaptured, charge. This is the second half of the two-step payment flow, where first you [created a charge](#create-a-new-charge) with the capture option set to false.

Uncaptured payments expire exactly seven days after they are created. If they are not captured by that point in time, they will be marked as refunded and will no longer be capturable.

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
            <td>amount</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount for the transaction.</td>
        </tr>
        <tr>
            <td>application_fee</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An application fee to add on to this charge. Can only be used with Stripe Connect.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The email address to send this charge’s receipt to.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$charge = $stripe->charges()->capture('ch_4ECWMVQp5SJKEx');
```
