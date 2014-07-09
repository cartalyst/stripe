## Extending Models

Extending the default models is very easy, we provide handy methods you can utilise with your Entity model.

Firstly you create your model(s) and this model needs to extend the model you want to "override", here how to do it:

```php
<?php

use Cartalyst\Stripe\Billing\Models\IlluminateCard;

class Card extends IlluminateCard {

	// you can apply any new methods/logic here

}
```

> **Note:** Please use the list below for a complete list of models namespace paths.

### Models list

Model Name      | Model full namespace path
--------------- | --------------------------------------------------------------
Card            | Cartalyst\Stripe\Billing\Models\IlluminateCard
Charge          | Cartalyst\Stripe\Billing\Models\IlluminateCharge
ChargeRefund    | Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund
Invoice         | Cartalyst\Stripe\Billing\Models\IlluminateInvoice
InvoiceItem     | Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
InvoiceMetadata | Cartalyst\Stripe\Billing\Models\IlluminateInvoiceMetadata
Subscription    | Cartalyst\Stripe\Billing\Models\IlluminateSubscription

### Set the models

Now that you've the model(s) created, it's time to set them, this is recommended to be done the earlier as you can on your application.

This can be done for example on the `app/filters.php`, this is to ensure you only require to apply this change once per request!

#### Change the Card model

```php
app('User')->setCardModel('Acme\Models\Card');
```

#### Change the Charge model

```php
app('User')->setChargeModel('Acme\Models\Charge');
```

#### Change the Charge Refunds model

```php
app('User')->setChargeRefundModel('Acme\Models\ChargeRefund');
```

#### Change the Invoice model

```php
app('User')->setInvoiceModel('Acme\Models\Invoice');
```

#### Change the Invoice Items model

```php
app('User')->setInvoiceItemModel('Acme\Models\InvoiceItem');
```

#### Change the Invoice Metadata model

```php
app('User')->setInvoiceMetadataModel('Acme\Models\InvoiceMetadata');
```

#### Change the Subscription model

```php
app('User')->setSubscriptionModel('Acme\Models\Subscription');
```

> **Note:** The `User` model we're using for these examples, is the model you've applied the Billable Trait!
