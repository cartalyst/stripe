#### Create a card

When you create a new credit card, you must specify a customer to create it on.

Creating a new credit card will not change the card owner's existing default credit card. If the card's owner has no default credit card, the added credit card will become the default.

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
            <td>$parameters</td>
            <td>true</td>
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
            <td>source</td>
            <td>true</td>
            <td>string | array</td>
            <td>null</td>
            <td>The source can either be a token or a dictionary containing the source details.</td>
        </tr>
    </tbody>
</table>

##### Usage

###### Through the Stripe.js Token (recommended)

```php
$card = $stripe->cards()->create('cus_4EBumIjyaKooft', [
    'card' => $_POST['stripeToken'],
]);
```

###### Manually

```php
$card = $stripe->cards()->create('cus_4EBumIjyaKooft', [
    'number'    => '4242424242424242',
    'exp_month' => 6,
    'exp_year'  => 2015,
    'cvc'       => '314',
]);
```
