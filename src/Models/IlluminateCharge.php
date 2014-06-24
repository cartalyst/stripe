<?php namespace Cartalyst\Stripe\Models;
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
		'refunded',
		'stripe_id',
		'created_at',
		'description',
	];

	/**
	 * The Eloquent refunds model.
	 *
	 * @var string
	 */
	protected static $refundModel = 'Cartalyst\Stripe\Models\IlluminateRefund';

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
	 * Returns all the refunds associated to this charge.
	 *
	 * @return \Cartalyst\Stripe\Models\IlluminateRefund
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
	 * Sets the Eloquent model to be used for refunds relationships.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setRefundModel($model)
	{
		static::$refundModel = $model;
	}

}
