# Drop the tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_cards`;
DROP TABLE IF EXISTS `stripe_discounts`;
DROP TABLE IF EXISTS `stripe_invoice_items`;
DROP TABLE IF EXISTS `stripe_invoices`;
DROP TABLE IF EXISTS `stripe_payment_refunds`;
DROP TABLE IF EXISTS `stripe_payments`;
DROP TABLE IF EXISTS `stripe_subscriptions`;

# Update the billable tables
# ------------------------------------------------------------

{{billable_tables_down}}
