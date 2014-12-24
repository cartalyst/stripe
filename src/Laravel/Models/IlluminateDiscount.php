<?php namespace Cartalyst\Stripe\Laravel\Models;
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

class IlluminateDiscount extends IlluminateModel {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'stripe_discounts';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'ends_at',
		'starts_at',
		'discount_id',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'ends_at',
		'starts_at',
	];

	/**
	 *
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function scopeActiveDiscount($query)
	{
		return $query->orderBy('created_at', 'desc')->first();
	}

	// public function coupon()
	// {
	// 	return $this->belongsTo(
	// 		'Cartalyst\Stripe\Models\IlluminateCoupon',
	// 		'discount_id' # rename to "coupon_id"
	// 	);
	// }

	############################################################################
	public function getCouponAttribute($coupon)
	{
		return json_decode($coupon);
	}

	public function setCouponAttribute(array $coupon)
	{
		$this->attributes['coupon'] = json_encode($coupon);
	}
	############################################################################

	/**
	 *
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return (bool) $this->coupon->valid;
	}

}
