#### Attach a source

Attaches the Source to a Customer.

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
            <td>$sourceId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The source unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$source = $stripe->sources()->attach('cus_FtAnrEozrF5NDy', 'src_1FR439Eind3TueVhKWibD8fH');
```
