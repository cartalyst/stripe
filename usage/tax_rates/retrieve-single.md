#### Retrieve a tax rate

Retrieves the details of an existing tax rate.

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
            <td>$taxRateId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The tax rate unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$taxRate = $stripe->taxRates()->find('txr_1FR43AEind3TueVhoseBEvm9');

echo $taxRate['jurisdiction'];
```
