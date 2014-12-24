# Dump of table stripe_cards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_cards`;

CREATE TABLE `stripe_cards` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`billable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`billable_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`fingerprint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`brand` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	`funding` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	`cvc_check` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	`last_four` char(4) COLLATE utf8_unicode_ci NOT NULL,
	`exp_month` tinyint(3) unsigned NOT NULL,
	`exp_year` smallint(5) unsigned NOT NULL,
	`default` tinyint(1) NOT NULL DEFAULT '0',
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	KEY `stripe_cards_billable_type_index` (`billable_type`),
	KEY `stripe_cards_billable_id_index` (`billable_id`),
	KEY `stripe_cards_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_discounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_discounts`;

CREATE TABLE `stripe_discounts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`discountable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`discountable_id` int(10) unsigned NOT NULL,
	`coupon` text COLLATE utf8_unicode_ci NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`starts_at` timestamp NULL DEFAULT NULL,
	`ends_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `stripe_discounts_discountable_type_index` (`discountable_type`),
	KEY `stripe_discounts_discountable_id_index` (`discountable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_invoice_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_invoice_items`;

CREATE TABLE `stripe_invoice_items` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`billable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`billable_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`invoice_id` int(11) NOT NULL,
	`currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`amount` decimal(15,4) NOT NULL,
	`proration` tinyint(1) NOT NULL DEFAULT '0',
	`description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`plan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`quantity` int(10) unsigned DEFAULT NULL,
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`period_start` timestamp NULL DEFAULT NULL,
	`period_end` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `stripe_invoice_items_billable_type_index` (`billable_type`),
	KEY `stripe_invoice_items_billable_id_index` (`billable_id`),
	KEY `stripe_invoice_items_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_invoices`;

CREATE TABLE `stripe_invoices` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`billable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`billable_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`subscription_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`subtotal` decimal(15,4) NOT NULL,
	`total` decimal(15,4) NOT NULL,
	`application_fee` decimal(15,4) DEFAULT NULL,
	`amount_due` decimal(15,4) NOT NULL,
	`attempted` tinyint(1) NOT NULL DEFAULT '0',
	`attempt_count` int(10) unsigned NOT NULL DEFAULT '0',
	`closed` tinyint(1) NOT NULL DEFAULT '0',
	`paid` tinyint(1) NOT NULL DEFAULT '0',
	`metadata` text COLLATE utf8_unicode_ci NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`period_start` timestamp NULL DEFAULT NULL,
	`period_end` timestamp NULL DEFAULT NULL,
	`next_payment_attempt` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `stripe_invoices_billable_type_index` (`billable_type`),
	KEY `stripe_invoices_billable_id_index` (`billable_id`),
	KEY `stripe_invoices_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_payment_refunds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_payment_refunds`;

CREATE TABLE `stripe_payment_refunds` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`payment_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`amount` decimal(15,4) NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	KEY `stripe_payment_refunds_payment_id_index` (`payment_id`),
	KEY `stripe_payment_refunds_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_payments`;

CREATE TABLE `stripe_payments` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`billable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`billable_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`invoice_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`amount` decimal(15,4) NOT NULL,
	`paid` tinyint(1) NOT NULL DEFAULT '0',
	`captured` tinyint(1) NOT NULL DEFAULT '0',
	`refunded` tinyint(1) NOT NULL DEFAULT '0',
	`failed` tinyint(1) NOT NULL DEFAULT '0',
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	KEY `stripe_payments_billable_type_index` (`billable_type`),
	KEY `stripe_payments_billable_id_index` (`billable_id`),
	KEY `stripe_payments_stripe_id_index` (`stripe_id`),
	KEY `stripe_payments_invoice_id_index` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dump of table stripe_subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripe_subscriptions`;

CREATE TABLE `stripe_subscriptions` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`billable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`billable_id` int(10) unsigned NOT NULL,
	`stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`plan_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
	`active` tinyint(1) NOT NULL DEFAULT '0',
	`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`period_starts_at` timestamp NULL DEFAULT NULL,
	`period_ends_at` timestamp NULL DEFAULT NULL,
	`ended_at` timestamp NULL DEFAULT NULL,
	`canceled_at` timestamp NULL DEFAULT NULL,
	`trial_starts_at` timestamp NULL DEFAULT NULL,
	`trial_ends_at` timestamp NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `stripe_subscriptions_billable_type_index` (`billable_type`),
	KEY `stripe_subscriptions_billable_id_index` (`billable_id`),
	KEY `stripe_subscriptions_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Update the billable tables
# ------------------------------------------------------------

{{billable_tables_up}}
