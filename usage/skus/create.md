#### Create an SKU

Creates a new product object.

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
            <td>id</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The identifier for the SKU. Must be unique. If not provided, an identifier will be randomly generated.</td>
        </tr>
        <tr>
            <td>currency</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>3-letter ISO code for currency.</td>
        </tr>
        <tr>
            <td>inventory</td>
            <td>true</td>
            <td>array</td>
            <td>[]</td>
            <td>Description of the SKU’s inventory.</td>
        </tr>
        <tr>
            <td>price</td>
            <td>true</td>
            <td>number</td>
            <td>null</td>
            <td>The cost of the item as a positive integer in the smallest currency unit (that is, 100 cents to charge $1.00, or 1 to charge ¥1, Japanese Yen being a 0-decimal currency).</td>
        </tr>
        <tr>
            <td>product</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of the product this SKU is associated with.</td>
        </tr>
        <tr>
            <td>active</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Only return products that are active or inactive (e.g. pass false to list all inactive products).</td>
        </tr>
        <tr>
            <td>attributes</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A list of up to 5 alphanumeric attributes that each SKU can provide values for (e.g. `[ "color", "size" ]`).</td>
        </tr>
        <tr>
            <td>image</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The URL of an image for this SKU, meant to be displayable to the customer.</td>
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
    </tbody>
</table>

##### Usage

```php
$sku = $stripe->skus()->create([
    'product'   => 'pr_16nYIkJvzVWl1WTezKYABD87',
    'price'     => 1500,
    'currency'  => 'usd',
    'inventory' => [
        'type'     => 'finite',
        'quantity' => 500
    ],
    'attributes' => [
        'size'   => 'Medium',
        'gender' => 'Unisex',
    ],
]);

echo $sku['id'];
```
