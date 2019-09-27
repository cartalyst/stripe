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
            <td>City/District/Suburb/Town/Village.</td>
        </tr>
        <tr>
            <td>address_country</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Billing address country, if provided when creating card.</td>
        </tr>
        <tr>
            <td>address_line1</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Address line 1 (Street address/PO Box/Company name). </td>
        </tr>
        <tr>
            <td>address_line2</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Address line 2 (Apartment/Suite/Unit/Building).</td>
        </tr>
        <tr>
            <td>address_state</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>State/County/Province/Region.</td>
        </tr>
        <tr>
            <td>address_zip</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ZIP or postal code.</td>
        </tr>
        <tr>
            <td>exp_month</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Two digit number representing the card’s expiration month.</td>
        </tr>
        <tr>
            <td>exp_year</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Four digit number representing the card’s expiration year.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a card object.</td>
        </tr>
        <tr>
            <td>name</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Cardholder name.</td>
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
