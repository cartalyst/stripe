#### Create a product

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
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The products unique identifier.</td>
        </tr>
        <tr>
            <td>name</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The product’s name, meant to be displayable to the customer.</td>
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
            <td>caption</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A short one-line description of the product, meant to be displayable to the customer.</td>
        </tr>
        <tr>
            <td>description</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The product’s description, meant to be displayable to the customer.</td>
        </tr>
        <tr>
            <td>images</td>
            <td>false</td>
            <td>array</td>
            <td>[]</td>
            <td>A list of up to 8 URLs of images for this product, meant to be displayable to the customer.</td>
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
            <td>shippable</td>
            <td>false</td>
            <td>boolean</td>
            <td>true</td>
            <td>Whether this product is shipped (i.e. physical goods). Defaults to `true`.</td>
        </tr>
        <tr>
            <td>url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A URL of a publicly-accessible webpage for this product.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$product = $stripe->products()->create([
    'name'        => 'T-shirt',
    'description' => 'Comfortable gray cotton t-shirts',
    'attributes'  => [ 'size', 'gender' ]
]);

echo $product['id'];
```
