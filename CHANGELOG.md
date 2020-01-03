# Change Log

This project follows [Semantic Versioning](CONTRIBUTING.md).

## Proposals

We do not give estimated times for completion on `Accepted` Proposals.

- [Accepted](https://github.com/cartalyst/stripe/labels/Accepted)
- [Rejected](https://github.com/cartalyst/stripe/labels/Rejected)

---

### v2.4.0 - 2019-12-21

`ADDED`

- Account Links API
- Account Capabilities API
- Balance Transactions API

`REMOVED`

- Cartalyst Collections dependency, since it was no longer being used.
- Subscription Schedule Revisions API since it was fully removed from the Stripe API
- The `verify()` method from the Account API. Stripe made it more difficult to make this verification more straightforward, so this method was unfortunately redundant.

### v2.3.1 - 2020-01-02

`SECURITY`

- Remove usage of the unsafe `getenv` method outside of CLI

### v2.3.0 - 2019-09-27

`UPDATED`

- Api Key checker moved to the create handler method.

### v2.2.12 - 2019-09-10

`ADDED`

- Add all method to the Setup Intents API

### v2.2.11 - 2019-09-05

`FIXED`

- Not being able to pass extra parameters when deleting a Subscription Item.

### v2.2.10 - 2019-07-15

`ADDED`

- Add methods to get and set the application information on the user agent headers.

### v2.2.9 - 2019-07-08

`ADDED`

- Add CustomerBalanceTransactions API

### v2.2.8 - 2019-07-08

`FIXED`

- Issue with Pager where ids could be nullable.

### v2.2.7 = 2019-07-06

`UPDATED`

- Invoices API `pay()` method to allow parameters to be passed as the second argument when paying an invoice.

### v2.2.6 - 2019-07-03

`ADDED`

- Add SetupIntents API

### v2.2.5 - 2019-07-03

`UPDATED`

- Subscriptions API list method to allow to retrieve all subscriptions from the Stripe account instead of only the subscriptions of a customer.

### v2.2.4 - 2019-06-30

`ADDED`

- Add Customer Tax Ids API
- Add Radar Early Fraud Warning API
- Add Tax Rates API

`UPDATED`

- Improved Idempotency support

### v2.2.3 - 2019-06-29

`UPDATED`

- Subscriptions API endpoint to use the current supported one.

### v2.2.2 - 2019-06-16

`FIXED`

- Version constant.

### v2.2.1 - 2019-05-15

`ADDED`

- Stripe response headers to the StripeException object

### v2.2.0 - 2019-04-21

`ADDED`

- Account > Persons API
- Checkout > Sessions API
- CreditNotes API
- FileLinks API
- PaymentMethods API
- PaymentIntents API
- Radar > Reviews API
- Radar > Value Lists API
- Radar > Value List Items API
- SubscriptionSchedules API
- SubscriptionScheduleRevisions API
- Terminal > Connection Tokens
- Terminal > Locations
- Terminal > Readers
- Top-ups API
- WebhookEndpoints API
- Method to the Sources API to retrieve all sources of a customer
- Method to the Invoices API to send the invoice to the customer
- Method to the Invoices API to delete a draft invoice
- Method to the Invoices API to finalize an invoice
- Method to the Invoices API to void an invoice
- Method to the Invoices API to mark an invoice as uncollectible
- Method to the UsageRecords API to retrieves all usage record summary

`UPDATED`

- Added extra $parameters argument to the `upcomingInvoice` method
- Rename FileUploads to Files (backward compatible)
- Remove parameters argument from Payouts Cancel endpoint

### v2.1.4 - 2018-04-11

`ADDED`

- Method to the Sources API to attach a source to a customer.
- Method to the Sources API to detach a source from a customer.
- Method to the Account API to create a login link.
- Sigma Scheduled Queries API
    - Allows to find a scheduled query
    - Allows to retrieve all scheduled queries
- Usage Records API

### v2.1.3 - 2018-04-08

`UPDATED`

- Some of the methods on the Account API class to allow the usage of the new Stripe API endpoints.

### v2.1.2 - 2018-02-22

`FIXED`

- Issue on `all()` method on Bank Accounts API to also return Cards.
- Issue on `all()` method on Cards API to also return Bank Accounts.

### v2.1.1 - 2018-01-12

`FIXED`

- Issue when creating a card and not being able to pass metadata or other attributes.
- Sources API class to use the proper Stripe Sources endpoint.

`ADDED`

- Support for Ephemeral Keys.

### v2.1.0 - 2017-05-10

`ADDED`

- PHP 7.1 support.
- Add Payouts API endpoint.

`REMOVED`

- HHVM support.

### v2.0.9 - 2017-03-09

`FIXED`

- Issue with account id being invalid without being set.

`UPDATED`

- Account test to be more performant and faster to finish.

### v2.0.8 - 2017-01-27

`ADDED`

- Method to set the connected account.

### v2.0.7 - 2016-09-23

`ADDED`

- Method to disable the amount converter.

`UPDATED`

- Stripe Exception to retrieve the error response that Stripe returns.

### v2.0.6 - 2016-07-19

`UPDATED`

- Stripe API version to the latest.

`FIXED`

- Iterator not working as expected when passing parameters.
- Issue where retrieving all subscriptions were not working as expected.
- Fix issue with idempotency key.

### v2.0.5 - 2016-06-24

`ADDED`

- Method to verify a connected account.
- Method to verify a bank account.
- Various missing endpoints.

`FIXED`

- Create method on the File Uploads endpoint.

`UPDATED`

- Test coverage.

### v2.0.4 - 2016-04-27

`ADDED`

- Guzzle retry middleware.

### v2.0.3 - 2016-02-26

`ADDED`

- Country Specs API.
- Delete endpoint to the Skus API.

### v2.0.2 - 2016-02-17

`FIXED`

- Fixed exception handler to only handle client exceptions.

### v2.0.1 - 2016-02-10

`FIXED`

- Version constant on Stripe class.

### v2.0.0 - 2016-01-17

`UPDATED`

- Updated to Guzzle 6.

### v1.0.10 - 2016-06-24

`ADDED`

- Method to verify a connected account.
- Method to verify a bank account.
- Various missing endpoints.

`FIXED`

- Create method on the File Uploads endpoint.

`UPDATED`

- Test coverage.

### v1.0.9 - 2016-02-26

`ADDED`

- Country Specs API.
- Delete endpoint to the Skus API.

### v1.0.8 - 2016-02-17

`FIXED`

- Fixed `__call` method to work with Mockery.

### v1.0.7 - 2015-12-12

`FIXED`

- Issue when the rate limit was reached a wrong exception was being thrown.

### v1.0.6 - 2015-10-14

`FIXED`

- Issue where the amount was not being converted properly if passed without decimals! This reverts the previous fix with a better fix.

`ADDED`

- Bank Accounts (ExternalAccounts) API.
- API tests.

### v1.0.5 - 2015-09-29

`ADDED`

- [Relay](https://stripe.com/relay) endpoints.

### v1.0.4 - 2015-09-18

`FIXED`

- Issue where the `amount` that was not being automatically converted properly.

`ADDED`

- A new `AmountConverter` class that automatically converts the `amount`.
- A methods to the Stripe class to get and set the Amount Converter class easily.

### v1.0.3 - 2015-07-08

`FIXED`

- Wrong returns on some docblocks.
- Incorrect coding standards.

### v1.0.2 - 2015-06-30

`ADDED`

- `.gitattributes` and `.travis.yml` file.

### v1.0.1 - 2015-06-03

`ADDED`

- Added new methods to create and update an account and to retrieve all the connected accounts.

### v1.0.0 - 2015-04-02

`INIT`

- Initial release.
