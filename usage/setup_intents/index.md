### Setup Intents

A SetupIntent guides you through the process of setting up a customer's payment credentials for future payments. For example, you could use a SetupIntent to set up your customer's card without immediately collecting a payment. Later, you can use PaymentIntents to drive the payment flow.

Create a SetupIntent as soon as you're ready to collect your customer's payment credentials. Do not maintain long-lived, unconfirmed SetupIntents as they may no longer be valid. The SetupIntent then transitions through multiple statuses as it guides you through the setup process.

Successful SetupIntents result in payment credentials that are optimized for future payments. For example, cardholders in certain regions may need to be run through Strong Customer Authentication at the time of payment method collection in order to streamline later off-session payments.

By using SetupIntents, you ensure that your customers experience the minimum set of required friction, even as regulations change over time.
