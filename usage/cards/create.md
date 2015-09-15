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
            <td>string | array</td>
            <td>null</td>
            <td>The card can either be a token or a dictionary containing the card details.</td>
        </tr>
    </tbody>
</table>

##### Usage

You have 3 different but very similar ways to create cards on Stripe.

###### Through a Stripe.js Token (recommended)

```php
$card = $stripe->cards()->create('cus_4EBumIjyaKooft', $_POST['stripe_token']);
```

> **Note:** The name of the `stripe_token` field might be different on your application!

###### Through a Stripe API Token

```php
$token = $stripe->tokens()->create([
    'card' => [
        'number'    => '4242424242424242',
        'exp_month' => 10,
        'cvc'       => 314,
        'exp_year'  => 2020,
    ],
]);

$card = $stripe->cards()->create('cus_4EBumIjyaKooft', $token['id']);
```

> **Note:** Please refer to the [Token documentation](#tokens) for more information.

###### Through an array

```php
$card = $stripe->cards()->create('cus_4EBumIjyaKooft', [
    'number'    => '4242424242424242',
    'exp_month' => 10,
    'cvc'       => 314,
    'exp_year'  => 2020,
]);
```
