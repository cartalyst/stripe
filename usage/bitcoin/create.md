#### Create a Bitcoin Receiver

Creates a Bitcoin receiver object that can be used to accept bitcoin payments from your customer. The receiver exposes a Bitcoin address and is created with a bitcoin to USD exchange rate that is valid for 10 minutes.

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
            <td>amount</td>
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount representing how much to charge the card.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a charge object.</td>
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
            <td>A set of key/value pairs that you can attach to a charge object.</td>
        </tr>
        <tr>
            <td>refund_mispayments</td>
            <td>false</td>
            <td>bool</td>
            <td>null</td>
            <td>A flag that indicates whether you would like Stripe to automatically handle refunds for any [mispayments](https://stripe.com/docs/guides/bitcoin#mispayments) to the receiver.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$receiver = $stripe->bitcoin()->create([
    'currency'    => 'USD',
    'amount'      => 50.49,
    'description' => 'Receiver for John Doe',
]);

echo $receiver['id'];
```
