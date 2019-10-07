#### Retrieve a source

Retrieves a Source object.

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
$source = $stripe->sources()->find('src_1FR3sfEind3TueVhD5ZyAvz8');
```
