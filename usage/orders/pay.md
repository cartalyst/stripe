#### Pay an order

Pay an order by providing a source to create a payment.

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
            <td>$orderId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The order unique identifier.</td>
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
            <td>customer</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of an existing customer that will be charged in this request.</td>
        </tr>
        <tr>
            <td>source</td>
            <td>false</td>
            <td>string | array</td>
            <td>null</td>
            <td>A payment source to be charged, such as a credit card. If you also pass a customer ID, the source must be the ID of a source belonging to the customer. Otherwise, if you do not pass a customer ID, the source you provide must either be a token, like the ones returned by Stripe.js, or a associative array containing a user's credit card details, with the options described below. Although not all information is required, the extra info helps prevent fraud.</td>
        </tr>
        <tr>
            <td>email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The email address of the customer placing the order. If a `customer` is specified, that customer's email address will be used.</td>
        </tr>
        <tr>
            <td>application_fee</td>
            <td>false</td>
            <td>integer</td>
            <td>null</td>
            <td>An application fee to add on to this order payment.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$order = $stripe->orders()->pay('or_16nYXbJvzVWl1WTe7t5ODS8z');

echo $order['status'];
```
