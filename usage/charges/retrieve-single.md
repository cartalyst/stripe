#### Retrieve a charge

Retrieves the details of a charge that has been previously created. Supply the unique charge ID that was returned from a previous request, and Stripe will return the corresponding charge information. The same information is returned when creating or refunding the charge.

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
            <td>$chargeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The charge unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$charge = $stripe->charges()->find('ch_4ECWMVQp5SJKEx');
```
