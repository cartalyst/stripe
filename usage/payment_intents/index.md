### Payment Intents

A Payment Intent guides you through the process of collecting a payment from your customer.

We recommend that you create exactly one Payment Intent for each order or customer session in your system. You can reference the Payment Intent later to see the history of payment attempts for a particular session.

A Payment Intent transitions through multiple statuses throughout its lifetime as it interfaces with Stripe.js to perform authentication flows and ultimately creates at most one successful charge.
