#### Update a source

Updates a Source object.

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
            <td>$customerId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The customer unique identifier. (This is for backwards compatibility.)</td>
        </tr>
        <tr>
            <td>$sourceId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The source unique identifier.</td>
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
            <td>numeric</td>
            <td>null</td>
            <td>Amount associated with the source.</td>
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
            <td>A set of key/value pairs that you can attach to a payment method object.</td>
        </tr>
        <tr>
            <td>owner</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Information about the owner of the payment instrument that may be used or required by particular source types.</td>
        </tr>
        <tr>
            <td>source_order</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Parameters required for the redirect flow. Required if the source is authenticated by a redirect (`flow` is `redirect`).</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$source = $stripe->sources()->update('cus_4EBumIjyaKooft', 'src_1FR439Eind3TueVhKWibD8fH', [
    'metadata' => [
        'order_id' => '123456',
    ],
]);
```
