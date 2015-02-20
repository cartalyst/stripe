#### Retrieve all transfers

Returns a list of existing transfers sent to third-party bank accounts or that Stripe has sent you. The transfers are returned in sorted order, with the most recently created transfers appearing first.

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
            <td>created</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A filter on the list based on the object created field.</td>
        </tr>
        <tr>
            <td>date</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A filter on the list based on the object date field.</td>
        </tr>
        <tr>
            <td>ending_before</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>limit</td>
            <td>false</td>
            <td>integer</td>
            <td>10</td>
            <td>A limit on the number of objects to be returned.</td>
        </tr>
        <tr>
            <td>recipient</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient unique identifier.</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>status</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return transfers that have the given status: `pending`, `paid`, or `failed`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$transfers = $stripe->transfers()->all();

foreach ($transfers['data'] as $transfer)
{
    var_dump($transfer['id']);
}
```
