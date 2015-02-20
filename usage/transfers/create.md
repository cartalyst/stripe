#### Create a transfer

To send funds from your Stripe account to a third-party recipient or to your own bank account, you create a new transfer object. Your [Stripe balance](https://stripe.com/docs/api#balance) must be able to cover the transfer amount, or you'll receive an "Insufficient Funds" error.

If your API key is in test mode, money won't actually be sent, though everything else will occur as if in live mode.

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
            <td>$transferId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The transfer unique identifier.</td>
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
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>A positive amount for the transaction.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>recipient</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of an existing, verified recipient.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>bank_account</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>If a recipient has both a bank account and a card attached, this parameter or the `card` parameter must be provided, but never both.</td>
        </tr>
        <tr>
            <td>card</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card unique identifier.</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which will be displayed on the recipient's bank or card statement.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$transfer = $stripe->transfers()->create([
    'amount'    => 10.00,
    'currency'  => 'USD',
    'recipient' => 'rp_4EYxxX0LQWYDMs',
]);

echo $transfer['id'];
```
