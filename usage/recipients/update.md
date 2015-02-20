#### Update a recipient

Updates the specified recipient by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

If you update the name or tax ID, the identity verification will automatically be rerun. If you update the bank account, the bank account validation will automatically be rerun.

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
            <td>$recipientId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient unique identifier.</td>
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
            <td>name</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient's full, legal name.</td>
        </tr>
        <tr>
            <td>tax_id</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient's tax ID, as a string. For type individual, the full SSN; for type corporation, the full EIN.</td>
        </tr>
        <tr>
            <td>bank_account</td>
            <td>false</td>
            <td>string | array</td>
            <td>null</td>
            <td>A bank account to attach to the recipient.</td>
        </tr>
        <tr>
            <td>card</td>
            <td>false</td>
            <td>string | array</td>
            <td>null</td>
            <td>The card token or an array.</td>
        </tr>
        <tr>
            <td>default_cart</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card unique identifier.</td>
        </tr>
        <tr>
            <td>email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient's email address.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string which you can attach to a recipient object.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a recipient object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$recipient = $stripe->recipients()->update('rp_5jSK7FKTY7mMbr', [
    'name' => 'John Doe Inc.',
]);
```
