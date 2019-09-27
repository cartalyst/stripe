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
            <td>application_fee_amount</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An application fee amount to add on to this charge, which must be less than or equal to the original amount. Can only be used with Stripe Connect.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The email address to send this charge’s receipt to.</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string to be displayed alongside your company name on your customer's credit card statement.</td>
        </tr>
        <tr>
            <td>statement_descriptor_suffix</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Provides information about the charge that customers see on their statements.</td>
        </tr>
        <tr>
            <td>transfer_data</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>An optional dictionary including the account to automatically transfer to as part of a destination charge</td>
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
$charge = $stripe->charges()->capture('ch_4ECWMVQp5SJKEx');
```
