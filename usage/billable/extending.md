### Extending Models

Extending the default models is very easy, we provide handy methods you can utilise with your Entity model.

Firstly you create your model(s) and this model needs to extend the model you want to "override", here's an example on how to do it:

```php
<?php

use Cartalyst\Stripe\Billing\Models\IlluminateCard;

class Card extends IlluminateCard {

	// You can create any new methods here or if
	// required, you can override any existing
	// method to apply your custom features.

}
```

> **Note:** Please use the list below for a complete list of models namespace paths.

#### Models list

Model Name   | Model full namespace path
------------ | -----------------------------------------------------------------
Card         | Cartalyst\Stripe\Billing\Models\IlluminateCard
Charge       | Cartalyst\Stripe\Billing\Models\IlluminateCharge
ChargeRefund | Cartalyst\Stripe\Billing\Models\IlluminateChargeRefund
Invoice      | Cartalyst\Stripe\Billing\Models\IlluminateInvoice
InvoiceItem  | Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
Subscription | Cartalyst\Stripe\Billing\Models\IlluminateSubscription

#### Set the models

Now that you've the model(s) created, it's time to set them.

This can be done where you see it's more appropriate on your application, as an example, you can do this on the `app/filters.php` file, this is to ensure you only apply this change once per request!

> **Note:** We recommended that this should be done the earlier as you can on your application.

###### $entity->setCardModel()

This method will change the card model on the entity.

```php
User::setCardModel('Acme\Models\Card');
```

###### $entity->setChargeModel()

This method will change the charge model on the entity.

```php
User::setChargeModel('Acme\Models\Charge');
```

###### $entity->setChargeRefundModel()

This method will change the charge refunds model on the entity.

```php
User::setChargeRefundModel('Acme\Models\ChargeRefund');
```

###### $entity->setInvoiceModel()

This method will change the invoice model on the entity.

```php
User::setInvoiceModel('Acme\Models\Invoice');
```

###### $entity->setInvoiceItemModel()

This method will change the invoice items model on the entity.

```php
User::setInvoiceItemModel('Acme\Models\InvoiceItem');
```

###### $entity->setSubscriptionModel()

This method will change the subscription model on the entity.

```php
User::setSubscriptionModel('Acme\Models\Subscription');
```

> **Note:** The `User` model we're using for these examples, is the model you've applied the Billable Trait!
