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
		'metadata',
		'subtotal',
		'attempted',
		'charge_id',
		'stripe_id',
		'amount_due',
		'created_at',
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
	 * The Eloquent charge model.
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
	 * The Eloquent subscription model.
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
	 * Returns the subscription that is associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function subscription()
	{
		return $this->belongsTo(static::$subscriptionModel, 'subscription_id');
	}

	/**
	 * Get mutator for the "metadata" attribute.
	 *
	 * @param  string  $metadata
	 * @return array
	 */
	public function getMetadataAttribute($metadata)
	{
		return $metadata ? json_decode($metadata, true) : [];
	}

	/**
	 * Set mutator for the "metadata" attribute.
	 *
	 * @param  array  $metadata
	 * @return void
	 */
	public function setMetadataAttribute(array $metadata)
	{
		$this->attributes['metadata'] = json_encode($metadata);
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
