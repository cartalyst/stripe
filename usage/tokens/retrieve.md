#### Retrieve a token

Retrieves the token with the given ID.

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
            <td>$tokenId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The token unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$token = $stripe->tokens()->find('tok_15D2JOJvzVWl1WTewpv4hU8c');
```
