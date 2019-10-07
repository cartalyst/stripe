#### Create a source

Creates a Source object.

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
            <td>type</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The type of the Source.</td>
        </tr>
        <tr>
            <td>amount</td>
            <td>false</td>
            <td>numeric</td>
            <td>null</td>
            <td>Amount associated with the source.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Three-letter ISO code for the currency associated with the source.</td>
        </tr>
        <tr>
            <td>flow</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The authentication `flow` of the source to create. The `flow` is one of `redirect`, `receiver`, `code_verification`, `none`. It is generally inferred unless a type supports multiple flows.</td>
        </tr>
        <tr>
            <td>mandate</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Information about a mandate possibility attached to a source object (generally for bank debits) as well as its acceptance status.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a source object.</td>
        </tr>
        <tr>
            <td>owner</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Information about the owner of the payment instrument that may be used or required by particular source types.</td>
        </tr>
        <tr>
            <td>receiver</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Optional parameters for the receiver flow. Can be set only if the source is a receiver (`flow` is `receiver)`.</td>
        </tr>
        <tr>
            <td>redirect</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Parameters required for the redirect flow. Required if the source is authenticated by a redirect (`flow` is `redirect`).</td>
        </tr>
        <tr>
            <td>source_order</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Parameters required for the redirect flow. Required if the source is authenticated by a redirect (`flow` is `redirect`).</td>
        </tr>
        <tr>
            <td>statement_descriptor</td>
            <td>false</td>
            <td>string</td>
            <td></td>
            <td>An arbitrary string to be displayed on your customer’s statement.</td>
        </tr>
        <tr>
            <td>token</td>
            <td>false</td>
            <td>string</td>
            <td></td>
            <td>An optional token used to create the source.</td>
        </tr>
        <tr>
            <td>usage</td>
            <td>false</td>
            <td>string</td>
            <td></td>
            <td>Either `reusable` or `single_use`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$source = $stripe->sources()->create([
    'type' => 'ach_credit_transfer',
    'currency' => 'usd',
    'owner' => [
        'email' => 'jenny.rosen@example.com'
    ],
]);

echo $source['id'];
```
