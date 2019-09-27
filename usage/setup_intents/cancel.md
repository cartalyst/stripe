#### Cancel a setup intent

A Setup Intent can be canceled when it is in one of these statuses: `requires_payment_method`, `requires_capture`, `requires_confirmation`, `requires_action`.

Once canceled, setup is abandoned and any operations on the SetupIntent will fail with an error.

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
            <td>$setupIntentId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The setup intent unique identifier.</td>
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
            <td>cancellation_reason</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Reason for canceling this Setup Intent. Possible values are `abandoned`, `requested_by_customer`, or `duplicate`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$setupIntent = $stripe->setupIntents()->cancel('seti_123456789');
```
