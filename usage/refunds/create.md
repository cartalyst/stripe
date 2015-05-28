#### Create a refund

Creating a new refund will refund a charge that has previously been created but not yet refunded. Funds will be refunded to the credit or debit card that was originally charged. The fees you were originally charged are also refunded.

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
            <td>$amount</td>
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount representing how much of this charge to refund.</td>
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
            <td>refund_application_fee</td>
            <td>false</td>
            <td>boolean</td>
            <td>false</td>
            <td>Boolean indicating whether the application fee should be refunded when refunding this refund.</td>
        </tr>
        <tr>
            <td>reason</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>String indicating the reason for the refund. If set, possible values are `duplicate`, `fraudulent`, and `requested_by_customer`.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a refund object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$refund = $stripe->refunds()->create('ch_4ECWMVQp5SJKEx');
```
