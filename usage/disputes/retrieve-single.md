#### Retrieve a dispute

Retrieves the dispute with the given ID.

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
            <td>$disputeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The dispute unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$dispute = $stripe->disputes()->find('dp_1FNKXICyvLc26QsPT1TD52kl');

echo $dispute['status'];
```
