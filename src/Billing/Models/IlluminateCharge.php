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

class IlluminateCharge extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'payments';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'paid',
		'amount',
		'captured',
		'currency',
		'refunded',
		'stripe_id',
		'created_at',
		'invoice_id',
		'description',
	];

	/**
	 * The Eloquent invoice model.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoice';

	/**
	 * The Eloquent refund model.
	 *
	 * @var string
	 */
	protected static $refundModel = 'Cartalyst\Stripe\Billing\Models\IlluminateRefund';

	/**
	 * Checks if the charge is partially refunded.
	 *
	 * @return bool
	 */
	public function isPartialRefunded()
	{
		return ( ! $this->refunded && $this->refunds->count());
	}

	/**
	 * Returns the invoice associated to this charge.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	public function invoice()
	{
		return $this->hasOne(static::$invoiceModel, 'stripe_id', 'invoice_id');
	}

	/**
	 * Sets the Eloquent model to be used for the invoice relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceModel($model)
	{
		static::$invoiceModel = $model;
	}

	/**
	 * Returns all the refunds associated to this charge.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateRefund
	 */
	public function refunds()
	{
		return $this->hasMany(static::$refundModel, 'payment_id');
	}

	/**
	 * Get mutator for the "amount_refunded" attribute.
	 *
	 * @return float
	 */
	public function getAmountRefundedAttribute()
	{
		return $this->refunds()->sum('amount');
	}

	/**
	 * Sets the Eloquent model to be used for the refund relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setRefundModel($model)
	{
		static::$refundModel = $model;
	}

}
