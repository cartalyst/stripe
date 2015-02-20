#### Delete a card

You can delete cards from a customer.

If you delete a card that is currently the default card on a customer, the most recently added card will be used as the new default.

If you delete the last remaining card on a customer, the default_card attribute on the card's owner will become null.

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
$card = $stripe->cards()->delete('cus_4EBumIjyaKooft', 'card_4DmaB3muM8SNdZ');
```
