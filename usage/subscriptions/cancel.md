#### Cancel a subscription

Cancels a customer's subscription. If you set the `atPeriodEnd` argument to true, the subscription will remain active until the end of the period, at which point it will be canceled and not renewed. By default, the subscription is terminated immediately. In either case, the customer will not be charged again for the subscription. Note, however, that any pending invoice items that you've created will still be charged for at the end of the period unless manually deleted. If you've set the subscription to cancel at period end, any pending prorations will also be left in place and collected at the end of the period, but if the subscription is set to cancel immediately, pending prorations will be removed.

By default, all unpaid invoices for the customer will be closed upon subscription cancellation. We do this in order to prevent unexpected payment retries once the customer has canceled a subscription. However, you can reopen the invoices manually after subscription cancellation to have us proceed with automatic retries, or you could even re-attempt payment yourself on all unpaid invoices before allowing the customer to cancel the subscription at all.

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
            <td>$customerId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The customer unique identifier.</td>
        </tr>
        <tr>
            <td>$subscriptionId</td>
            <td>true</td>
            <td>string</td>
            <td>null</td>
            <td>The subscription unique identifier.</td>
        </tr>
        <tr>
            <td>$atPeriodEnd</td>
            <td>false</td>
            <td>boolean</td>
            <td>false</td>
            <td>A flag that if set to true will delay the cancellation of the subscription until the end of the current period.</td>
        </tr>
    </tbody>
</table>

```php
$subscription = $stripe->subscriptions()->cancel('cus_4EBumIjyaKooft', 'sub_4ETjGeEPC5ai9J');
```

###### Cancel at the end of the period

```php
$subscription = $stripe->subscriptions()->cancel('cus_4EBumIjyaKooft', 'sub_4ETjGeEPC5ai9J', true);
```
