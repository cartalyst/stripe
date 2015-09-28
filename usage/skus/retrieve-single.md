#### Retrieve a SKU

Retrieves the details of an existing SKU. Supply the unique SKU identifier from either a SKU creation request or from the product, and Stripe will return the corresponding SKU information.

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
            <td>$skuId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The SKU unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$sku = $stripe->skus()->find('t-shirt-small-red');

echo $sku['name'];
```
