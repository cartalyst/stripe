#### Retrieve a file

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
            <td>$fileId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The file unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$file = $stripe->files()->find('file_1EwIDlEind3TueVhON4nGOZi');

echo $file['url'];
```
