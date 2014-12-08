# Stripe Change Log

This project follows [Semantic Versioning](CONTRIBUTING.md).

## Proposals

We do not give estimated times for completion on `Accepted` Proposals.

- [Accepted](https://github.com/cartalyst/stripe/labels/Accepted)
- [Rejected](https://github.com/cartalyst/stripe/labels/Rejected)

---

### v0.2.0 - TBA ([UPGRADE GUIDE](#..))

`ADDED`

- Added a base Illuminate Model that all the Billable models extends.
- Added a new Customer Gateway class to handle customer creation, updates and deletion.

`CHANGED`

- Webhook controller moved into the `Laravel` folder.
- Table names are now prefixed with `stripe_` to avoid table collision.
- Updated the table indexes to reflect the table name changes.
- Billable Trait, Interface, Gateways and models moved out of the `Billable` folder into the `src/`.
- Tweaked the Stripe API class and base API Model collection.
- Renamed the Table command class and file name.
- Very minor tweaks on the Table command.
- Updated the billable trait to use the new Customer Gateway class.
- Improvements on most of the Gateways.
- Updated the Laravel Service Provider.
- Renamed the `getVersion()` and `setVersion()` methods on the Stripe API class to `getApiVersion()` and `setApiVersion()`.
- Renamed the `$version` property on the Stripe API class to `$apiVersion`.
- Added a `getVersion()` to the Stripe API class that returns the current package version.

`REMOVED`

- Removed the `getStripeId()` method from the Billable Trait and Interface.

### v0.1.1 - 2014-11-14

`FIXED`

- Fix issue with the subscription swap() method creating a new entry when it wasn't required.

### v0.1.0 - 2014-11-14

`ADDED`

- Stripe API.
- Stripe Billing Entities features.
- Laravel Service Provider and Facade.
- Stripe Webhook Controller for Laravel.
