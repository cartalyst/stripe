<?php
/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCartalystStripeV100 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stripe_cards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billable_type')->index();
			$table->integer('billable_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->string('fingerprint');
			$table->string('brand', 20);
			$table->string('funding', 10);
			$table->string('cvc_check', 10);
			$table->char('last_four', 4);
			$table->tinyInteger('exp_month')->unsigned();
			$table->smallInteger('exp_year')->unsigned();
			$table->boolean('default')->default(0);
			$table->timestamps();

			$table->engine = 'InnoDB';
		});

		// Schema::create('stripe_coupons', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->string('stripe_id')->index();
		// 	$table->enum('duration', [ 'forever', 'once', 'repeating' ])->default('once');
		// 	$table->integer('amount_off')->nullable()->unsigned();
		// 	$table->integer('percent_off')->nullable()->unsigned();
		// 	$table->string('currency')->nullable();
		// 	$table->integer('duration_in_months')->nullable()->unsigned();
		// 	$table->integer('max_redemptions')->nullable()->unsigned();
		// 	$table->timestamp('redeem_by')->nullable()->nullable();
		// 	$table->integer('times_redeemed')->unsigned();
		// 	$table->boolean('valid')->default(0);
		// 	$table->text('metadata');
		// 	$table->timestamps();
		// 	$table->softDeletes();

		// 	$table->engine = 'InnoDB';
		// });

		# probably instead of having a stripe_coupons table, we can have the table
		# for the future sync commands, but, for each discount, we store the
		# relevant data on a json format, this way we can still access
		# the coupon information when required, even when the coupon
		# has been deleted.
		Schema::create('stripe_discounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('discountable_type')->index();
			$table->integer('discountable_id')->index()->unsigned();
			//$table->integer('coupon_id');
			$table->text('coupon');
			$table->timestamps();
			$table->timestamp('starts_at')->nullable();
			$table->timestamp('ends_at')->nullable();

			$table->engine = 'InnoDB';
 		});

		Schema::create('stripe_invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billable_type')->index();
			$table->integer('billable_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->string('subscription_id')->nullable();
			$table->string('currency');
			$table->string('description')->nullable();
			$table->decimal('subtotal', 15, 4);
			$table->decimal('total', 15, 4);
			$table->decimal('application_fee', 15, 4)->nullable();
			$table->decimal('amount_due', 15, 4);
			$table->boolean('attempted')->default(0);
			$table->integer('attempt_count')->unsigned()->default(0);
			$table->boolean('closed')->default(0);
			$table->boolean('paid')->default(0);
			$table->text('metadata');
			$table->timestamps();
			$table->timestamp('period_start')->nullable();
			$table->timestamp('period_end')->nullable();
			$table->timestamp('next_payment_attempt')->nullable();

			$table->engine = 'InnoDB';
		});

		Schema::create('stripe_invoice_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billable_type')->index();
			$table->integer('billable_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->integer('invoice_id');
			$table->string('currency');
			$table->string('type')->nullable();
			$table->decimal('amount', 15, 4);
			$table->boolean('proration')->default(0);
			$table->string('description')->nullable();
			$table->string('plan')->nullable();
			$table->integer('quantity')->unsigned()->nullable();
			$table->timestamps();
			$table->timestamp('period_start')->nullable();
			$table->timestamp('period_end')->nullable();

			$table->engine = 'InnoDB';
		});

		Schema::create('stripe_payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billable_type')->index();
			$table->integer('billable_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->string('invoice_id')->index()->nullable();
			$table->string('currency');
			$table->string('description')->nullable();
			$table->decimal('amount', 15, 4);
			$table->boolean('paid')->default(0);
			$table->boolean('captured')->default(0);
			$table->boolean('refunded')->default(0);
			$table->boolean('failed')->default(0);
			$table->timestamps();

			$table->engine = 'InnoDB';
		});

		Schema::create('stripe_payment_refunds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('payment_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->string('currency');
			$table->decimal('amount', 15, 4);
			$table->timestamps();

			$table->engine = 'InnoDB';
		});

		Schema::create('stripe_subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('billable_type')->index();
			$table->integer('billable_id')->index()->unsigned();
			$table->string('stripe_id')->index();
			$table->string('plan_id', 25)->nullable();
			$table->boolean('active')->default(0);
			$table->timestamps();
			$table->timestamp('period_starts_at')->nullable();
			$table->timestamp('period_ends_at')->nullable();
			$table->timestamp('ended_at')->nullable();
			$table->timestamp('canceled_at')->nullable();
			$table->timestamp('trial_starts_at')->nullable();
			$table->timestamp('trial_ends_at')->nullable();

			$table->engine = 'InnoDB';
		});

{{billable_tables_up}}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$tables = [
			'stripe_cards',
			'stripe_coupons',
			'stripe_invoices',
			'stripe_payments',
			'stripe_discounts',
			'stripe_invoice_items',
			'stripe_subscriptions',
			'stripe_payment_refunds'
		];

		foreach ($tables as $table) Schema::drop($table);

{{billable_tables_down}}
	}

}
