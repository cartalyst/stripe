#### Update a card

If you need to update only some card details, like the billing address or expiration date, you can do so without having to re-enter the full card details.

When you update a card, Stripe will automatically validate the card.

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
        <tr>
            <td>$parameters</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Please refer to the list below for a valid list of keys that can be passed on this array.</td>
        </tr>
    </tbody>
</table>

###### $parameters

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
            <td>address_city</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder address city.</td>
        </tr>
        <tr>
            <td>address_line1</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder address line 1.</td>
        </tr>
        <tr>
            <td>address_line2</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder address line 2.</td>
        </tr>
        <tr>
            <td>address_state</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder address state.</td>
        </tr>
        <tr>
            <td>address_zip</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder address zip code.</td>
        </tr>
        <tr>
            <td>exp_month</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card expiration month.</td>
        </tr>
        <tr>
            <td>exp_year</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card expiration year.</td>
        </tr>
        <tr>
            <td>name</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The card holder name.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$card = $stripe->cards()->update('cus_4EBumIjyaKooft', 'card_4DmaB3muM8SNdZ', [
    'name'          => 'John Doe',
    'address_line1' => 'Example Street 1',
]);
```
