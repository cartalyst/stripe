#### Retrieve all SKUs

Returns a list of your SKUs. The SKUs are returned sorted by creation date, with the most recently created SKUs appearing first.

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
            <td>active</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Only return SKUs that are active or inactive (e.g. pass `false` to list all inactive products).</td>
        </tr>
        <tr>
            <td>attributes</td>
            <td>false</td>
            <td>array</td>
            <td>null</td>
            <td>Only return SKUs that have the specified key/value pairs in this partially constructed dictionary. Can be specified only if `product` is also supplied. For instance, if the associated product has attributes `["color", "size"]`, passing in `attributes[color]=red` returns all the SKUs for this product that have `color` set to `red`.</td>
        </tr>
        <tr>
            <td>ending_before</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>ids</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return SKUs with the given IDs.</td>
        </tr>
        <tr>
            <td>in_stock</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return SKUs that are either in stock or out of stock (e.g. pass false to list all SKUs that are out of stock). If no value is provided, all SKUs are returned.</td>
        </tr>
        <tr>
            <td>limit</td>
            <td>false</td>
            <td>integer</td>
            <td>10</td>
            <td>A limit on the number of objects to be returned.</td>
        </tr>
        <tr>
            <td>product</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>The ID of the product whose SKUs will be retrieved.</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$skus = $stripe->skus()->all();

foreach ($skus['data'] as $sku) {
    var_dump($sku['id']);
}
```
