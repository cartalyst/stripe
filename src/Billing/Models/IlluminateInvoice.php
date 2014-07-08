<?php namespace Cartalyst\Stripe\Billing\Models;
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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IlluminateInvoice extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'invoices';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'paid',
		'total',
		'closed',
		'currency',
		'subtotal',
		'stripe_id',
		'charge_id',
		'attempted',
		'amount_due',
		'period_end',
		'description',
		'period_start',
		'attempt_count',
		'subscription_id',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'period_end',
		'period_start',
	];

	/**
	 * The Eloquent charges model.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCharge';

	/**
	 * The Eloquent invoice items model.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem';

	/**
	 * The Eloquent invoice metadata model.
	 *
	 * @var string
	 */
	protected static $invoiceMetadataModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceMetadata';

	/**
	 * The Eloquent subscriptions model.
	 *
	 * @var string
	 */
	protected static $subscriptionModel = 'Cartalyst\Stripe\Billing\Models\IlluminateSubscription';

	/**
	 * Returns the charge that is associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function charge()
	{
		return $this->belongsTo(static::$chargeModel, 'id');
	}

	/**
	 * Returns all the items associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
	 */
	public function items()
	{
		return $this->hasMany(static::$invoiceItemModel, 'invoice_id');
	}

	/**
	 * Returns the metadata associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoiceMetadata
	 */
	public function metadata()
	{
		return $this->hasOne(static::$invoiceMetadataModel, 'invoice_id');
	}

	/**
	 * Returns the subscription that is associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function subscription()
	{
		return $this->belongsTo(static::$subscriptionModel, 'subscription_id');
	}

	/**
	 * Sets the Eloquent model to be used for the charge relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeModel($model)
	{
		static::$chargeModel = $model;
	}

	/**
	 * Sets the Eloquent model to be used for the invoice items relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceItemModel($model)
	{
		static::$invoiceItemModel = $model;
	}

	/**
	 * Sets the Eloquent model to be used for the invoice metadata relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceMetadataModel($model)
	{
		static::$invoiceMetadataModel = $model;
	}

	/**
	 * Sets the Eloquent model to be used for the subscription relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setSubscriptionModel($model)
	{
		static::$subscriptionModel = $model;
	}

}
