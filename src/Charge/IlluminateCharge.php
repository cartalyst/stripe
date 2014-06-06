<?php namespace Cartalyst\Stripe\Charge;
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
		'amount',
		'captured',
		'refunded',
		'description',
	];

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
	 * @return \Cartalyst\Stripe\Charge\IlluminateRefund
	 */
	public function refunds()
	{
		return $this->hasMany('Cartalyst\Stripe\Charge\IlluminateRefund', 'payment_id');
	}

	/**
	 * Get mutator for the "amount" attribute.
	 *
	 * @param  int  $amount
	 * @return float
	 */
	public function getAmountAttribute($amount)
	{
		return number_format($amount / 100, 2);
	}

	/**
	 * Get mutator for the "amount_refunded" attribute.
	 *
	 * @return float
	 */
	public function getAmountRefundedAttribute()
	{
		$amount = $this->refunds()->sum('amount');

		return number_format($amount / 100, 2);
	}

}
