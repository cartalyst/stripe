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
	 * Get mutator for the "attempted" attribute.
	 *
	 * @param  string  $attempted
	 * @return int
	 */
	public function getAttemptedAttribute($attempted)
	{
		return (int) $attempted;
	}

	/**
	 * Get mutator for the "attempt_count" attribute.
	 *
	 * @param  string  $attempt_count
	 * @return int
	 */
	public function getAttemptCountAttribute($attempt_count)
	{
		return (int) $attempt_count;
	}

	/**
	 * Get mutator for the "closed" attribute.
	 *
	 * @param  string  $closed
	 * @return bool
	 */
	public function getClosedAttribute($closed)
	{
		return (bool) $closed;
	}

	/**
	 * Get mutator for the "paid" attribute.
	 *
	 * @param  string  $paid
	 * @return bool
	 */
	public function getPaidAttribute($paid)
	{
		return (bool) $paid;
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
	 * Checks if the invoice is closed.
	 *
	 * @return bool
	 */
	public function isClosed()
	{
		return $this->closed === true;
	}

	/**
	 * Checks if the invoice is paid.
	 *
	 * @return bool
	 */
	public function isPaid()
	{
		return $this->paid === true;
	}

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
	 * Returns the Eloquent model to be used for the charge relationship.
	 *
	 * @return string
	 */
	public static function getChargeModel()
	{
		return static::$chargeModel;
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
	 * Returns all the items associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem
	 */
	public function items()
	{
		return $this->hasMany(static::$invoiceItemModel, 'invoice_id');
	}

	/**
	 * Returns the Eloquent model to be used for the invoice items relationship.
	 *
	 * @return string
	 */
	public static function getInvoiceItemModel()
	{
		return static::$invoiceItemModel;
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
	 * Returns the subscription that is associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function subscription()
	{
		return $this->belongsTo(static::$subscriptionModel, 'subscription_id');
	}

	/**
	 * Returns the Eloquent model to be used for the subscription relationship.
	 *
	 * @return string
	 */
	public static function getSubscriptionModel()
	{
		return static::$subscriptionModel;
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
