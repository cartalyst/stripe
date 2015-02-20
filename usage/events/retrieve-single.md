#### Retrieve an event

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
            <td>$eventId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The event unique identifier.</td>
        </tr>
    </tbody>
</table>

##### Usage

```php
$event = $stripe->events()->find('evt_4ECnKrmXyNn8IM');

echo $event['type'];
```
