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

class IlluminateCoupon extends IlluminateModel {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'stripe_coupons';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'valid',
		'currency',
		'duration',
		'metadata',
		'redeem_by',
		'stripe_id',
		'created_at',
		'amount_off',
		'percent_off',
		'times_redeemed',
		'max_redemptions',
		'duration_in_months',
	];

	/**
	 * Get mutator for the "metadata" attribute.
	 *
	 * @param  string  $metadata
	 * @return array
	 */
	public function getMetadataAttribute($metadata)
	{
		return json_decode($metadata);
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

}
