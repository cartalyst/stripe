#### Create a customer

Creates a new customer object.

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
            <td>address</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>The customer’s address.</td>
        </tr>
        <tr>
            <td>balance</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>Current balance, if any, being stored on the customer. If negative, the customer has credit to apply to their next invoice. If positive, the customer has an amount owed that will be added to their next invoice.</td>
        </tr>
        <tr>
            <td>coupon</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Coupon identifier that applies a discount on all recurring charges.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string that you can attach to a customer object.</td>
        </tr>
        <tr>
            <td>email</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Customer’s email address.</td>
        </tr>
        <tr>
            <td>invoice_prefix</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The prefix for the customer used to generate unique invoice numbers.</td>
        </tr>
        <tr>
            <td>invoice_settings</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Default invoice settings for this customer.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a customer object.</td>
        </tr>
        <tr>
            <td>name</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The customer’s full name or business name.</td>
        </tr>
        <tr>
            <td>payment_method</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>ID of the PaymentMethod to attach to the customer.</td>
        </tr>
        <tr>
            <td>phone</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The customer’s phone number.</td>
        </tr>
        <tr>
            <td>preferred_locales</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Customer’s preferred languages, ordered by preference.</td>
        </tr>
        <tr>
            <td>shipping</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Mailing and shipping address for the customer. Appears on invoices emailed to this customer.</td>
        </tr>
        <tr>
            <td>source</td>
            <td>false</td>
            <td>string | array</td>
            <td>null</td>
            <td>The source can either be a token or a dictionary containing the source details.</td>
        </tr>
        <tr>
            <td>tax_exempt</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Describes the customer’s tax exemption status</td>
        </tr>
        <tr>
            <td>tax_id_data</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The customer’s tax IDs.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$customer = $stripe->customers()->create([
    'email' => 'john@doe.com',
]);

echo $customer['id'];
```
