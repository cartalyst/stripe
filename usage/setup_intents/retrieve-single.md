#### Retrieve a setup intent

Retrieves the details of a Setup Intent that has previously been created.

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
            <td>$setupIntentId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The setup intent unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$setupIntent = $stripe->setupIntents()->find('seti_123456789');
```
