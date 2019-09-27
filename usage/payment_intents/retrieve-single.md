#### Retrieve a payment intent

Retrieves the details of a Payment Intent that has previously been created.

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
            <td>$paymentIntentId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The payment intent unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$paymentIntent = $stripe->paymentIntents()->find('pi_1FFOKyEind3TueVhoddAahvY');
```
