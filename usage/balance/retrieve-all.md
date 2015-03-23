#### Retrieve all the balance history

Returns a list of transactions that have contributed to the Stripe account balance (includes charges, refunds, transfers, and so on). The transactions are returned in sorted order, with the most recent transactions appearing first.

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
            <td>available_on</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>A filter on the list based on the object available_on field.</td>
        </tr>
        <tr>
            <td>created</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>A filter on the list based on the object created field.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td></td>
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
            <td>source</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>A filter on the list based on the object source field.</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>transfer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>For automatic Stripe transfers only, only returns transactions that were transferred out on the specified transfer ID.</td>
        </tr>
        <tr>
            <td>type</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only returns transactions of the given type. One of: `charge`, `refund`, `adjustment`, `application_fee`, `application_fee_refund`, `transfer` or `transfer_failure`.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$history = $stripe->balance()->all();

foreach ($history['data'] as $balance) {
    var_dump($balance['id']);
}
```
