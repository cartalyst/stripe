#### Create a recipient

Creates a new recipient object and verifies both the recipient's identity and, if provided, the recipient's bank account information or debit card.

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
            <td>name</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient's full, legal name.</td>
        </tr>
        <tr>
            <td>type</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>Type of the recipient: either `individual` or `corporation`.</td>
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
$recipient = $stripe->recipients()->create([
    'name' => 'John Doe',
    'type' => 'individual',
]);
```
