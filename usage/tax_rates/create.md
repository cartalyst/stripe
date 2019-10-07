#### Create a tax rate

Creates a new Tax Rate.

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
            <td>display_name</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The display name of the tax rate, which will be shown to users.</td>
        </tr>
        <tr>
            <td>inclusive</td>
            <td>true</td>
            <td>boolean</td>
            <td>null</td>
            <td>This specifies if the tax rate is inclusive or exclusive.</td>
        </tr>
        <tr>
            <td>percentage</td>
            <td>true</td>
            <td>numeric</td>
            <td>null</td>
            <td>This represents the tax rate percent out of 100.</td>
        </tr>
        <tr>
            <td>active</td>
            <td>false</td>
            <td>boolean</td>
            <td>true</td>
            <td>Flag determining whether the tax rate is active or inactive. Inactive tax rates continue to work where they are currently applied however they cannot be used for new applications.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>An arbitrary string attached to the tax rate for your internal use only. It will not be visible to your customers.</td>
        </tr>
        <tr>
            <td>jurisdiction</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The jurisdiction for the tax rate.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a tax rate object.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$taxRate = $stripe->taxRates()->create([
    'display_name' => 'VAT',
    'description' => 'VAT Germany',
    'jurisdiction' => 'DE',
    'percentage' => 19.0,
    'inclusive' => false,
]);

echo $taxRate['id'];
```
