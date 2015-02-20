#### Retrieve a plan

Retrieves the plan with the given ID.

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
            <td>$planId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The plan unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$plan = $stripe->plans()->find('monthly');

echo $plan['name'];
```
