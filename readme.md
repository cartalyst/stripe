# Stripe

A comprehensive billing and API package for [Stripe](https://stripe.com/).

The package requires PHP 5.4+ and follows the FIG standard PSR-4 to ensure a high level of interoperability between shared PHP.

Part of the Cartalyst Arsenal & licensed [Cartalyst PSL](license.txt). Code well, rock on.

The package was inspired in the Laravel Cashier by Taylor Otwell.

## Package Story

Package history and capabilities.

#### xx-May-14 - v1.0.0

#### API

- Charges
	- Create a new charge
	- Update an existing charge
	- Capture the payment of an existing, uncaptured, charge
	- Refund a charge
	- Retrieve all the charges
	- Retrieve an existing charge

- Refunds
	- Retrieve an existing refund
	- Update a refund
	- Retrieve all the refunds

- Customers
	- Create a new customer
	- Update an existing customer
	- Delete an existing customer
	- Retrieve all the existing customers
	- Retrieve an existing customer
	- Delete an existing customer discount

- Cards
	- Create a new card
	- Update a card
	- Delete a card
	- Retrieve all cards attached to a customer
	- Retrieve a card attached to an existing customer

- Subscriptions
	- Create a new subscription
	- Update a subscription
	- Cancel a subscription
	- Retrieve all active subscriptions
	- Retrieve an existing subscription
	- Delete an existing subscription discount

- Plans
	- Create a new plan
	- Update an existing plan
	- Delete an existing plan
	- Retrieve all the existing plans
	- Retrieve an existing plan

- Coupons
	- Create a new coupon
	- Delete an existing coupon
	- Retrieve all the existing coupons
	- Retrieve an existing coupon

- Invoices
	- Create a new invoice
	- Update an existing invoice
	- Delete an existing invoice
	- Retrieve all the existing invoices
	- Retrieve an existing invoice
	- Retrieve an existing invoice line items
	- Retrieve the upcoming invoice
	- Pay an existing invoice

- Invoice Items
	- Create a new invoice item
	- Update an existing invoice item
	- Delete an existing invoice item
	- Retrieve all the existing invoice items
	- Retrieve an existing invoice item

- Disputes
	- Update a dispute
	- Close a dispute

- Transfers
	- Create a new transfer
	- Update an existing transfer
	- Cancel an existing transfer
	- Retrieve all the existing transfers
	- Retrieve an existing transfer

- Recipients
	- Create a new recipient
	- Update an existing recipient
	- Delete an existing recipient
	- Retrieve all the existing recipients
	- Retrieve an existing recipient

- Application Fees
	- Retrieve all the existing application fees
	- Retrieve an existing application fee
	- Refund an application fee

- Account
	- Retrieve the account details

- Balance
	- Retrieve all the transactions
	- Retrieve an existing transaction balance history
	- Retrieve the current balance

- Events
	- Retrieve all the events
	- Retrieve an event

- Tokens
	- Create a new card token
	- Create a new bank account token
	- Retrieve an existing token

#### Billable entities

- Can apply a coupon to the user.
- Can swap the default user credit card.
- Can list all the attached credit cards.
- Can attach new credit cards.
- Can update existing credit cards.
- Can delete existing credit cards.
- Can make an existing credit card the default credit card.
- Can check if the user has any active credit cards.
- Can list all the charges the user has made.
- Can create a new charge.
- Can create a new charge to be captured later.
- Can create a new charge with a new credit card.
- Can refund charges.
- Can list all the subscriptions the user has.
- Can create a new subscription.
- Can create a new subscription with a trial period.
- Can create a new subscription and apply a coupon to the subscription.
- Can cancel an active subscription.
- Can cancel an active subscription at the end of the period.
- Can resume a canceled subscription.
- Can resume a canceled subscription and remove its trial period.
- Can resume a canceled subscription and change its trial period end date.
- Can apply a coupon to an existing subscription.
- Can remove a coupon from an existing subscription.
- Can apply a trial period on an existing subscription.
- Can remove a trial period from an existing subscription.
- Can check if the subscription is on its trial period.
- Can check if the subscription is canceled.
- Can check if the subscription has expired.
- Can check if the subscription is on the grace period.
- Can check if the user has any active subscriptions.

## Requirements

- PHP >=5.4

## Installation

Stripe is installable with Composer. Read further information on how to install.

[Installation Guide](https://cartalyst.com/manual/stripe#installation)

## Documentation

Refer to the following guide on how to use the Stripe package.

[Documentation](https://cartalyst.com/manual/stripe)

## Versioning

We version under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

## Contributing

Please read the [Contributing](contributing.md) guidelines.

## Support

Have a bug? Please create an [issue](https://github.com/cartalyst/stripe/issues) here on GitHub that conforms with [necolas's guidelines](https://github.com/necolas/issue-guidelines).

Follow us on Twitter, [@cartalyst](http://twitter.com/cartalyst).

Join us for a chat on IRC.

Server: irc.freenode.net
Channel: #cartalyst

Email: help@cartalyst.com
