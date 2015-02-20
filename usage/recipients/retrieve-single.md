#### Retrieve a recipient

Retrieves the details of an existing recipient. You need only supply the unique recipient identifier that was returned upon recipient creation.

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
            <td>$recipientId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The recipient unique identifier.</td>
        </tr>
        <tr>
            <td>$cardId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The card unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$recipient = $stripe->recipients()->find('rp_5jSK7FKTY7mMbr');

echo $recipient['id'];
```
