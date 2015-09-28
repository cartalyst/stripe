#### Updates an SKU

Updates the specific product by setting the values of the parameters passed. Any parameters not provided will be left unchanged.

Note that a product's `attributes` are not editable. Instead, you would need to deactivate the existing product and create a new one with the new attribute values.

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
            <td>active</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Only return products that are active or inactive (e.g. pass false to list all inactive products).</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>image</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL of an image for this SKU, meant to be displayable to the customer.</td>
        </tr>
        <tr>
            <td>inventory</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>Description of the SKU’s inventory.</td>
        </tr>
        <tr>
            <td>metadata</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A set of key/value pairs that you can attach to a transfer object.</td>
        </tr>
        <tr>
            <td>package_dimensions</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>The dimensions of this product, from the perspective of shipping. A SKU associated with this product can override this value by having its own `package_dimensions`.</td>
        </tr>
        <tr>
            <td>price</td>
            <td>false</td>
            <td>number</td>
            <td>null</td>
            <td>The cost of the item as a positive integer in the smallest currency unit (that is, 100 cents to charge $1.00, or 1 to charge ¥1, Japanese Yen being a 0-decimal currency).</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$sku = $stripe->skus()->update('sk_16nYNvJvzVWl1WTeba414tlY', [
    'metadata' => [
        'foo' => 'Bar',
    ],
]);

echo $sku['id'];
```
