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
		'stripe_id',
		'charge_id',
		'subscription_id',
		'currency',
		'description',
		'subtotal',
		'total',
		'amount_due',
		'attempted',
		'attempt_count',
		'closed',
		'paid',
		'period_start',
		'period_end',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'period_end',
		'period_start',
	];

	/**
	 * The Eloquent invoice items model.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Billing\Models\IlluminateInvoiceItem';

	/**
	 * Returns the charge that is associated to this invoice.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
	 */
	public function charge()
	{
		return $this->belongsTo('Cartalyst\Stripe\Billing\Models\IlluminateCharge', 'invoice_id');
	}

	/**
	 * Returns the charge that is associated to this subscription.
	 *
	 * @return \Cartalyst\Stripe\Billing\Models\IlluminateSubscription
	 */
	public function subscription()
	{
		return $this->belongsTo('Cartalyst\Stripe\Billing\Models\IlluminateSubscription', 'invoice_id');
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
	 * Sets the Eloquent model to be used for the invoice items relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setInvoiceItemModel($model)
	{
		static::$invoiceItemModel = $model;
	}

}
