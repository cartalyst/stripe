#### Retrieve a product

Retrieves the details of an existing product. Supply the unique product ID from either a product creation request or the product list, and Stripe will return the corresponding product information.

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
            <td>$productId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The product unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$product = $stripe->products()->find('prod_72587E4aVLiMy6');

echo $product['name'];
```
