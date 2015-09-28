#### Retrieve all products

Returns a list of your products. The products are returned sorted by creation date, with the most recently created products appearing first.

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
            <td>Only return products that are active or inactive (e.g. pass `false` to list all inactive products).</td>
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
            <td>Only return products with the given IDs.</td>
        </tr>
        <tr>
            <td>limit</td>
            <td>false</td>
            <td>integer</td>
            <td>10</td>
            <td>A limit on the number of objects to be returned.</td>
        </tr>
        <tr>
            <td>shippable</td>
            <td>false</td>
            <td>boolean</td>
            <td>null</td>
            <td>Only return products that can be shipped (i.e., physical, not digital products).</td>
        </tr>
        <tr>
            <td>starting_after</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>A cursor to be used in pagination.</td>
        </tr>
        <tr>
            <td>url</td>
            <td>false</td>
            <td>string</td>
            <td>null</td>
            <td>Only return products with the given url.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$products = $stripe->products()->all();

foreach ($products['data'] as $product) {
    var_dump($product['id']);
}
```
