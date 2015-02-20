#### Retrieve a Card

Retrieves the details of an existing credit card.

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
$card = $stripe->cards()->find('cus_4EBumIjyaKooft', 'card_4DmaB3muM8SNdZ');

echo $card['last4'];
```
