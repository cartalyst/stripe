#### Retrieve a Bitcoin Receiver

Retrieves the Bitcoin receiver with the given ID.

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
            <td>$receiverId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The bitcoin receiver unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$receiver = $stripe->bitcoin()->find('btcrcv_15YgkkJvzVWl1WTeNun8x4fB');

echo $receiver['description'];
```
