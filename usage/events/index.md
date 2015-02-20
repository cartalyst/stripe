### Events

Events are our way of letting you know about something interesting that has just happened in your account. When an interesting event occurs, we create a new event object. For example, when a charge succeeds we create a charge.succeeded event; or, when an invoice can't be paid we create an invoice.payment_failed event. Note that many API requests may cause multiple events to be created. For example, if you create a new subscription for a customer, you will receive both a customer.subscription.created event and a charge.succeeded event.
