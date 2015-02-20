#### Delete a plan

You can delete plans via the [plan management](https://dashboard.stripe.com/plans) page of the Stripe dashboard. However, deleting a plan does not affect any current subscribers to the plan; it merely means that new subscribers can't be added to that plan. You can also delete plans via the API.

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
$plan = $stripe->plans()->delete('monthly');
```
