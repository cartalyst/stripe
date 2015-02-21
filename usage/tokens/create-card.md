#### Create a card token

Creates a single use token that wraps the details of a credit card. This token can be used in place of a credit card dictionary with any API method. These tokens can only be used once: by [creating a new charge object](#create-a-charge), or attaching them to a [customer](#create-a-customer).

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
            <td>card</td>
            <td>true</td>
            <td>string | array</td>
            <td>null</td>
            <td>The card unique identifier.</td>
        </tr>
        <tr>
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A customer to create a token for.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$token = $stripe->tokens()->create([
    'card' => [
        'number'    => '4242424242424242',
        'exp_month' => 6,
        'exp_year'  => 2015,
        'cvc'       => 314,
    ],
]);

echo $token['id'];
```
