#### Retrieve all Bitcoin Receivers

Returns a list of your receivers. Receivers are returned sorted by creation date, with the most recently created receivers appearing first.

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
            <td>The customer unique identifier.</td>
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
            <td>active</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>A filter on the list to retreive only active receivers.</td>
        </tr>
        <tr>
            <td>ending_before</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>filled</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>A filter on the list to retreive only filled receivers.</td>
        </tr>
        <tr>
            <td>limit</td>
            <td>false</td>
            <td>integer</td>
            <td>10</td>
            <td>A limit on the number of objects to be returned.</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>uncaptured_funds</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>A filter on the list to retreive only receivers with uncaptured funds.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$receivers = $stripe->bitcoin()->all();

foreach ($receivers['data'] as $receiver)
{
    var_dump($receiver['id']);
}
```
