#### Create a charge

To charge a credit card, you need to create a new charge object. If your API key is in test mode, the supplied card won't actually be charged, though everything else will occur as if in live mode. (Stripe will assume that the charge would have completed successfully).

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
            <td>A positive amount representing how much to charge the card. Note that this should be a dollar amount, and will automatically be converted in to cents for you before being transmitted to Stripe.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The customer unique identifier.</td>
        </tr>
        <tr>
            <td>source</td>
            <td>true</td>
            <td>string | array</td>
            <td>null</td>
            <td>The source can either be a token or a dictionary containing the source details.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a charge object.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a charge object.</td>
        </tr>
        <tr>
            <td>capture</td>
            <td>false</td>
            <td>bool</td>
            <td>null</td>
            <td>Whether or not to immediately capture the charge.</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string to be displayed alongside your company name on your customer's credit card statement.</td>
        </tr>
        <tr>
            <td>receipt_email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The email address to send this charge’s receipt to.</td>
        </tr>
        <tr>
            <td>application_fee</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>An application fee to add on to this charge.</td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Shipping information for the charge. Helps prevent fraud on charges for physical goods.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$charge = $stripe->charges()->create([
    'customer' => 'cus_4EBumIjyaKooft',
    'currency' => 'USD',
    'amount'   => 50.49,
]);

echo $charge['id'];
```
