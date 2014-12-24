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

use Carbon\Carbon;

class IlluminateCard extends IlluminateModel {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'stripe_cards';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'brand',
		'default',
		'funding',
		'exp_year',
		'cvc_check',
		'exp_month',
		'last_four',
		'stripe_id',
		'fingerprint',
	];

	/**
	 * Accessor for the "default" attribute.
	 *
	 * @param  string  $default
	 * @return bool
	 */
	public function getDefaultAttribute($default)
	{
		return (int) $default;
	}

	/**
	 * Checks if the credit card is the default card.
	 *
	 * @return bool
	 */
	public function isDefault()
	{
		return (bool) $this->default;
	}

	/**
	 * Checks if the card has expired.
	 *
	 * @return bool
	 */
	public function hasExpired()
	{
		return Carbon::createFromDate($this->exp_year, $this->exp_month) < Carbon::now();
	}

}
