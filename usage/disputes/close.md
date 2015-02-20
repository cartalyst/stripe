#### Close a dispute

Closing the dispute for a charge indicates that you do not have any evidence to submit and are essentially 'dismissing' the dispute, acknowledging it as lost.

The status of the dispute will change from `under_review` to `lost`. Closing a dispute is irreversible.

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
            <td>$chargeId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The charge unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$dispute = $stripe->disputes()->close('ch_4ECWMVQp5SJKEx');
```
